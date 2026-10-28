#!/usr/bin/env python3
"""Inventory crawler for the legacy Chmuzuch site.

Outputs JSON, CSV and Markdown. It does not modify the source website.
Python 3.10+, dependency: beautifulsoup4.
"""
from __future__ import annotations
import argparse,csv,json,re,time
from collections import deque
from pathlib import Path
from urllib.error import HTTPError,URLError
from urllib.parse import parse_qs,urljoin,urlsplit,urlunsplit
from urllib.request import Request,urlopen
from bs4 import BeautifulSoup

DEFAULT_START="https://xn--g1ajvbu.xn--p1ai/"
DOC_EXT={".pdf",".doc",".docx",".xls",".xlsx",".ppt",".pptx",".zip",".rar",".rtf"}
MEDIA_EXT={".jpg",".jpeg",".png",".gif",".webp",".svg",".mp3",".wav",".ogg",".mp4",".webm",".avi",".mov"}
SKIP_SCHEMES=("mailto:","tel:","javascript:","#")

def normalize(base,href):
    if not href or href.startswith(SKIP_SCHEMES): return None
    u=urlsplit(urljoin(base,href.strip()))
    if u.scheme not in ("http","https"): return None
    # fragments never identify a separate resource
    return urlunsplit((u.scheme.lower(),u.netloc.lower(),u.path or "/",u.query,""))

def ext(url):
    return Path(urlsplit(url).path).suffix.lower()

def legacy_meta(url):
    q=parse_qs(urlsplit(url).query)
    return {"legacy_id":(q.get("id") or [None])[0],"legacy_page_type":(q.get("page") or [None])[0]}

def classify(url,title="",page_type=None):
    t=(title or "").lower()
    if ext(url) in DOC_EXT:return "document"
    if ext(url) in MEDIA_EXT:return "media"
    if "конференц" in t:return "conference"
    if "конкурс" in t:return "competition"
    if "отделени" in t:return "department"
    if "оркестр" in t or "ансамбл" in t or re.search(r"\bхор\b",t):return "collective"
    if "абитури" in t:return "applicant_page"
    if "общежит" in t:return "dormitory_page"
    if page_type=="news-item":return "news_or_page_manual_review"
    if page_type=="news-items":return "listing"
    return "page"

def fetch(url,timeout):
    req=Request(url,headers={"User-Agent":"ChmuzuchMigrationCrawler/1.0 (+https://github.com/asbcorp24/Chmuzuch)"})
    with urlopen(req,timeout=timeout) as r:
        body=r.read()
        ctype=r.headers.get_content_type()
        charset=r.headers.get_content_charset() or "utf-8"
        return r.status,ctype,body.decode(charset,errors="replace") if ctype in ("text/html","application/xhtml+xml") else ""

def crawl(start,max_pages,delay,timeout):
    root=urlsplit(start).netloc.lower()
    q=deque([(normalize(start,start),None,0)])
    seen=set(); rows=[]
    while q and len(rows)<max_pages:
        url,parent,depth=q.popleft()
        if not url or url in seen:continue
        seen.add(url)
        row={"legacy_url":url,"parent_legacy_url":parent,"depth":depth,**legacy_meta(url),
             "http_status":None,"title":"","content_kind":"","images_count":0,"documents_count":0,
             "internal_links_count":0,"external_links_count":0,"migration_status":"discovered","notes":""}
        if ext(url) in DOC_EXT|MEDIA_EXT:
            row["content_kind"]=classify(url); rows.append(row); continue
        try:
            status,ctype,html=fetch(url,timeout); row["http_status"]=status
            if "html" not in ctype:
                row["content_kind"]="binary"; rows.append(row); continue
            soup=BeautifulSoup(html,"html.parser")
            row["title"]=(soup.title.get_text(" ",strip=True) if soup.title else "")
            h1=soup.find("h1")
            if h1 and h1.get_text(" ",strip=True): row["title"]=h1.get_text(" ",strip=True)
            row["content_kind"]=classify(url,row["title"],row["legacy_page_type"])
            links=[]; docs=set(); imgs=set(); external=0
            for tag,attr in (("a","href"),("img","src"),("source","src"),("video","src"),("audio","src")):
                for node in soup.find_all(tag):
                    u=normalize(url,node.get(attr))
                    if not u:continue
                    if urlsplit(u).netloc.lower()!=root:
                        external+=1; continue
                    e=ext(u)
                    if e in DOC_EXT: docs.add(u)
                    if tag!="a" or e in MEDIA_EXT: imgs.add(u)
                    if tag=="a": links.append(u)
            row["images_count"]=len(imgs); row["documents_count"]=len(docs)
            row["external_links_count"]=external
            html_links=[u for u in links if ext(u) not in DOC_EXT|MEDIA_EXT]
            row["internal_links_count"]=len(set(html_links))
            for u in html_links:
                if u not in seen:q.append((u,url,depth+1))
            # inventory files too, without downloading them
            for u in sorted(docs|imgs):
                if u not in seen:q.append((u,url,depth+1))
            row["migration_status"]="classified"
        except HTTPError as e:
            row["http_status"]=e.code; row["content_kind"]="error"; row["notes"]=str(e)
        except (URLError,TimeoutError,UnicodeError,ValueError) as e:
            row["content_kind"]="error"; row["notes"]=repr(e)
        rows.append(row)
        if delay:time.sleep(delay)
    return rows

def write(rows,out):
    out.mkdir(parents=True,exist_ok=True)
    fields=["legacy_url","legacy_id","legacy_page_type","http_status","title","parent_legacy_url","depth",
            "content_kind","images_count","documents_count","internal_links_count","external_links_count",
            "migration_status","notes"]
    (out/"legacy-site-inventory.json").write_text(json.dumps(rows,ensure_ascii=False,indent=2),encoding="utf-8")
    with (out/"legacy-site-inventory.csv").open("w",encoding="utf-8-sig",newline="") as f:
        w=csv.DictWriter(f,fieldnames=fields);w.writeheader();w.writerows({k:r.get(k) for k in fields} for r in rows)
    kinds={}
    for r in rows:kinds[r["content_kind"]]=kinds.get(r["content_kind"],0)+1
    md=["# Legacy site crawl report","",f"Всего обнаружено: **{len(rows)}**.","","## По типам",""]
    md += [f"- {k or 'unknown'}: {v}" for k,v in sorted(kinds.items())]
    md += ["","## Страницы","", "| Тип | Заголовок | Legacy URL | Родитель |","|---|---|---|---|"]
    for r in rows:
        if r["content_kind"] not in ("document","media"):
            safe=(r["title"] or "").replace("|","\\|")
            md.append(f"| {r['content_kind']} | {safe} | {r['legacy_url']} | {r['parent_legacy_url'] or ''} |")
    (out/"legacy-site-report.md").write_text("\n".join(md)+"\n",encoding="utf-8")

def main():
    p=argparse.ArgumentParser()
    p.add_argument("--start",default=DEFAULT_START)
    p.add_argument("--max-pages",type=int,default=10000)
    p.add_argument("--delay",type=float,default=.15)
    p.add_argument("--timeout",type=float,default=20)
    p.add_argument("--out",default="storage/legacy-audit")
    a=p.parse_args()
    rows=crawl(a.start,a.max_pages,a.delay,a.timeout);write(rows,Path(a.out))
    print(f"Discovered {len(rows)} resources. Output: {a.out}")

if __name__=="__main__":main()
