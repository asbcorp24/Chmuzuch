import 'bootstrap';import * as THREE from 'three';
const root=document.getElementById('hero-3d');
if(root){
 const scene=new THREE.Scene(),camera=new THREE.PerspectiveCamera(45,1,.1,100),renderer=new THREE.WebGLRenderer({alpha:true,antialias:true});
 root.appendChild(renderer.domElement);camera.position.z=5;
 const knot=new THREE.Mesh(new THREE.TorusKnotGeometry(1.25,.28,180,24),new THREE.MeshStandardMaterial({color:0xc8a96a,metalness:.8,roughness:.24,wireframe:false}));
 scene.add(knot);scene.add(new THREE.AmbientLight(0xffffff,1.2));const light=new THREE.PointLight(0xd94a32,18);light.position.set(3,2,4);scene.add(light);
 const resize=()=>{const w=root.clientWidth||innerWidth,h=root.clientHeight||innerHeight;renderer.setSize(w,h,false);camera.aspect=w/h;camera.updateProjectionMatrix()};resize();addEventListener('resize',resize);
 const tick=()=>{knot.rotation.x+=.0015;knot.rotation.y+=.003;renderer.render(scene,camera);requestAnimationFrame(tick)};tick();
}

const mobileMenu=document.querySelector('.mobile-menu');
const menuToggle=document.querySelector('.menu-toggle');
const menuClose=document.querySelector('.menu-close');
function toggleMobileMenu(open){if(!mobileMenu)return;mobileMenu.classList.toggle('is-open',open);mobileMenu.setAttribute('aria-hidden',open?'false':'true');document.body.classList.toggle('menu-open',open);}
menuToggle?.addEventListener('click',()=>toggleMobileMenu(true));
menuClose?.addEventListener('click',()=>toggleMobileMenu(false));
mobileMenu?.querySelectorAll('a').forEach(link=>link.addEventListener('click',()=>toggleMobileMenu(false)));
document.addEventListener('keydown',e=>{if(e.key==='Escape')toggleMobileMenu(false);});
const visionToggle=document.querySelector('.vision-toggle');
if(localStorage.getItem('accessibleMode')==='1')document.documentElement.classList.add('accessible');
visionToggle?.addEventListener('click',()=>{const enabled=document.documentElement.classList.toggle('accessible');localStorage.setItem('accessibleMode',enabled?'1':'0');});
const cookieBanner=document.querySelector('.cookie-banner');
if(cookieBanner&&!localStorage.getItem('cookieConsent'))cookieBanner.hidden=false;
document.querySelector('.cookie-accept')?.addEventListener('click',()=>{localStorage.setItem('cookieConsent','accepted');if(cookieBanner)cookieBanner.hidden=true;});

const homeBlocks=document.querySelector('[data-home-blocks]');
if(homeBlocks){
 let dragged=null;
 homeBlocks.querySelectorAll('.home-block').forEach(block=>{
  block.addEventListener('dragstart',()=>{dragged=block;block.classList.add('dragging')});
  block.addEventListener('dragend',()=>{block.classList.remove('dragging');dragged=null});
  block.addEventListener('dragover',e=>{e.preventDefault();if(!dragged||dragged===block)return;const box=block.getBoundingClientRect();homeBlocks.insertBefore(dragged,e.clientY<box.top+box.height/2?block:block.nextSibling)});
 });
 const panel=document.querySelector('.inspector-panel'),empty=document.querySelector('.inspector-empty'),title=document.querySelector('[data-inspector-title]');
 document.querySelectorAll('.block-edit').forEach(btn=>btn.addEventListener('click',e=>{e.preventDefault();const block=btn.closest('.home-block');empty.hidden=true;panel.hidden=false;title.textContent=block.querySelector('h3').textContent;panel.querySelector('[data-field="title"]').value=block.querySelector('h3').textContent;panel.classList.toggle('editing-hero',block.dataset.id==='hero')}));
 document.querySelector('.home-save')?.addEventListener('click',()=>{const state=[...homeBlocks.querySelectorAll('.home-block')].map((b,i)=>({id:b.dataset.id,order:i,enabled:b.querySelector('input[type="checkbox"]').checked}));localStorage.setItem('chmuzuchHomeBuilder',JSON.stringify(state));const toast=document.querySelector('.builder-toast');toast.hidden=false;setTimeout(()=>toast.hidden=true,2200)});
}
