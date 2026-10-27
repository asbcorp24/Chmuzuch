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

const mediaManager=document.querySelector('.media-manager-layout');
if(mediaManager){
 const items=[...document.querySelectorAll('.media-item')],details=document.querySelector('.media-details-panel'),empty=document.querySelector('.media-details-empty');
 document.querySelectorAll('[data-media-filter]').forEach(btn=>btn.addEventListener('click',()=>{document.querySelectorAll('[data-media-filter]').forEach(b=>b.classList.remove('active'));btn.classList.add('active');const type=btn.dataset.mediaFilter;items.forEach(i=>i.hidden=type!=='all'&&i.dataset.type!==type)}));
 document.querySelector('.media-search input')?.addEventListener('input',e=>{const q=e.target.value.toLowerCase();items.forEach(i=>i.hidden=!i.dataset.name.toLowerCase().includes(q))});
 items.forEach(item=>item.addEventListener('click',()=>{items.forEach(i=>i.classList.remove('selected'));item.classList.add('selected');empty.hidden=true;details.hidden=false;details.querySelector('[data-media-name]').textContent=item.dataset.name;details.querySelector('[data-media-type]').textContent=item.dataset.type;details.querySelector('[data-media-title]').value=item.dataset.name}));
 const modal=document.querySelector('.media-upload-modal');document.querySelector('.media-upload-open')?.addEventListener('click',()=>modal.hidden=false);document.querySelector('.upload-close')?.addEventListener('click',()=>modal.hidden=true);modal?.addEventListener('click',e=>{if(e.target===modal)modal.hidden=true});
 document.querySelector('.upload-start')?.addEventListener('click',()=>{modal.hidden=true;alert('Интерфейс загрузки готов. Физическое сохранение подключим вместе с хранилищем CMS.')});
}

const inbox=document.querySelector('.inbox-layout');
if(inbox){
 const empty=inbox.querySelector('.inbox-empty'),card=inbox.querySelector('.request-card');
 inbox.querySelectorAll('.inbox-row').forEach(row=>row.addEventListener('click',()=>{inbox.querySelectorAll('.inbox-row').forEach(r=>r.classList.remove('active'));row.classList.add('active');empty.hidden=true;card.hidden=false;card.querySelector('[data-request-source]').textContent=row.dataset.source;card.querySelector('[data-request-subject]').textContent=row.dataset.subject;card.querySelector('[data-request-number]').textContent='#'+row.dataset.request;card.querySelector('[data-request-status]').value=row.dataset.status}));
}

const formFields=document.querySelector('[data-form-fields]');
if(formFields){
 let dragged=null;
 const bindField=field=>{field.addEventListener('dragstart',()=>{dragged=field;field.classList.add('dragging')});field.addEventListener('dragend',()=>{field.classList.remove('dragging');dragged=null});field.addEventListener('dragover',e=>{e.preventDefault();if(!dragged||dragged===field)return;const b=field.getBoundingClientRect();formFields.insertBefore(dragged,e.clientY<b.top+b.height/2?field:field.nextSibling)})};
 formFields.querySelectorAll('.form-field').forEach(bindField);
 document.querySelectorAll('[data-field-type]').forEach(btn=>btn.addEventListener('click',()=>{const field=document.createElement('article');field.className='form-field';field.draggable=true;field.dataset.type=btn.dataset.fieldType;field.innerHTML='<span class="drag-handle">⋮⋮</span><div><small>'+btn.dataset.fieldType+'</small><b>'+btn.querySelector('span').textContent+'</b><em>Новое поле</em></div><i>Необязательное</i><button>•••</button>';formFields.appendChild(field);bindField(field)}));
}

const blockLibrary=document.querySelector('.block-library'),formPicker=document.querySelector('.form-picker'),pageBlocks=document.querySelector('[data-page-blocks]');
if(blockLibrary&&pageBlocks){
 document.querySelector('.open-block-library')?.addEventListener('click',()=>blockLibrary.hidden=false);
 document.querySelector('.block-library-close')?.addEventListener('click',()=>blockLibrary.hidden=true);
 blockLibrary.addEventListener('click',e=>{if(e.target===blockLibrary)blockLibrary.hidden=true});
 document.querySelectorAll('[data-page-block]').forEach(btn=>btn.addEventListener('click',()=>{const type=btn.dataset.pageBlock;if(type==='form'){blockLibrary.hidden=true;formPicker.hidden=false;return;}const el=document.createElement('article');el.className='page-content-block';el.innerHTML='<span class="drag-handle">⋮⋮</span><div><small>'+type+'</small><b>'+btn.querySelector('span').textContent+'</b><p>Настройки блока будут доступны при выборе.</p></div><button>Настроить</button>';pageBlocks.appendChild(el);blockLibrary.hidden=true}));
}
if(formPicker){
 document.querySelector('.form-picker-close')?.addEventListener('click',()=>formPicker.hidden=true);
 formPicker.addEventListener('click',e=>{if(e.target===formPicker)formPicker.hidden=true});
 formPicker.querySelectorAll('[data-form-slug]').forEach(btn=>btn.addEventListener('click',()=>{const slug=btn.dataset.formSlug,name=btn.querySelector('b').textContent;const el=document.createElement('article');el.className='page-content-block embedded-form-block';el.dataset.form=slug;el.innerHTML='<span class="drag-handle">⋮⋮</span><div class="embedded-form-main"><small>Форма</small><b>'+name+'</b><div class="embedded-form-preview"><label>Поле формы<input disabled placeholder="Пример поля"></label><label>Поле формы<input disabled placeholder="Пример поля"></label><button disabled>Отправить</button></div></div><div class="embedded-form-actions"><label><span>Заголовок формы</span><input value="'+name+'"></label><label><span>После отправки</span><select><option>Показать сообщение</option><option>Перейти по ссылке</option></select></label><label class="switch-row"><span>Показывать описание</span><input type="checkbox" checked></label><a href="/admin/form-builder/'+slug+'">Редактировать форму</a><a href="/admin/form-reports/'+slug+'">Ответы / отчёт →</a></div>';pageBlocks.appendChild(el);formPicker.hidden=true}));
}

const schedule=document.querySelector('.schedule-shell');
if(schedule){
 const label=schedule.querySelector('[data-schedule-label]'),person=schedule.querySelector('[data-schedule-person]');
 schedule.querySelectorAll('[data-schedule-role]').forEach(btn=>btn.addEventListener('click',()=>{schedule.querySelectorAll('[data-schedule-role]').forEach(b=>b.classList.remove('active'));btn.classList.add('active');const teacher=btn.dataset.scheduleRole==='teacher';label.textContent=teacher?'Преподаватель':'Группа';person.innerHTML=teacher?'<option>Выберите преподавателя</option><option>Преподаватель · А</option><option>Преподаватель · Б</option>':'<option>Выберите группу</option><option>1 курс · группа</option><option>2 курс · группа</option><option>3 курс · группа</option><option>4 курс · группа</option>'}));
 schedule.querySelectorAll('[data-schedule-view]').forEach(btn=>btn.addEventListener('click',()=>{schedule.querySelectorAll('[data-schedule-view]').forEach(b=>b.classList.remove('active'));btn.classList.add('active');schedule.querySelector('[data-schedule-days]').classList.toggle('day-mode',btn.dataset.scheduleView==='day')}));
}

const feedbackForm=document.querySelector('#public-feedback-form');
if(feedbackForm){feedbackForm.addEventListener('submit',e=>{e.preventDefault();const status=document.querySelector('#feedback-status');if(!feedbackForm.checkValidity()){feedbackForm.reportValidity();if(status)status.textContent='Проверьте обязательные поля и согласие на обработку данных.';return;}if(status)status.textContent='Форма заполнена корректно. Серверный приём обращений будет подключён через модуль CMS.';});}
