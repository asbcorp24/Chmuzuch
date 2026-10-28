@if($siteMusicTracks->isNotEmpty())
<div id="site-music-player" class="site-music-player" aria-label="Музыкальный плеер">
<button type="button" id="music-collapse" aria-label="Свернуть плеер">♫</button>
<div class="music-player-body"><strong id="music-track-title">Музыка училища</strong><small id="music-track-artist"></small>
<div class="music-controls"><button type="button" id="music-prev" aria-label="Предыдущий">⏮</button><button type="button" id="music-toggle" aria-label="Воспроизвести">▶</button><button type="button" id="music-next" aria-label="Следующий">⏭</button><input id="music-progress" type="range" min="0" max="1000" value="0" aria-label="Перемотка"><input id="music-volume" type="range" min="0" max="1" step=".05" value=".7" aria-label="Громкость"></div>
</div><audio id="music-audio" preload="none"></audio>
</div>
<script>
(function(){
const tracks=@json($siteMusicTracks->map(fn($t)=>['title'=>$t->title,'artist'=>$t->artist,'url'=>$t->file_url])->values());
if(!tracks.length)return;
const root=document.getElementById('site-music-player'),audio=document.getElementById('music-audio'),play=document.getElementById('music-toggle'),progress=document.getElementById('music-progress'),volume=document.getElementById('music-volume');
let index=Math.min(Number(sessionStorage.getItem('siteMusicIndex')||0),tracks.length-1);
function load(){const t=tracks[index];audio.src=t.url;document.getElementById('music-track-title').textContent=t.title;document.getElementById('music-track-artist').textContent=t.artist||'';sessionStorage.setItem('siteMusicIndex',String(index));}
function start(){audio.play().catch(()=>{});}
document.getElementById('music-prev').onclick=()=>{index=(index+tracks.length-1)%tracks.length;load();start();};
document.getElementById('music-next').onclick=()=>{index=(index+1)%tracks.length;load();start();};
play.onclick=()=>audio.paused?start():audio.pause();
audio.onplay=()=>{play.textContent='❚❚';};audio.onpause=()=>{play.textContent='▶';};
audio.onended=()=>document.getElementById('music-next').click();
audio.ontimeupdate=()=>{if(audio.duration)progress.value=Math.floor(audio.currentTime/audio.duration*1000);};
progress.oninput=()=>{if(audio.duration)audio.currentTime=Number(progress.value)/1000*audio.duration;};
volume.oninput=()=>{audio.volume=Number(volume.value);localStorage.setItem('siteMusicVolume',volume.value);};
audio.volume=Number(localStorage.getItem('siteMusicVolume')||'.7');volume.value=audio.volume;
const collapsed=localStorage.getItem('siteMusicCollapsed')==='1';root.classList.toggle('collapsed',collapsed);
document.getElementById('music-collapse').onclick=()=>{root.classList.toggle('collapsed');localStorage.setItem('siteMusicCollapsed',root.classList.contains('collapsed')?'1':'0');};
load();
})();
</script>
@endif
