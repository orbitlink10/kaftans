document.documentElement.classList.add('has-js');
﻿const menu=document.querySelector('.menu-button');
menu?.addEventListener('click',()=>{const open=menu.getAttribute('aria-expanded')!=='true';menu.setAttribute('aria-expanded',String(open));document.querySelector('#navigation').classList.toggle('is-open',open)});
document.addEventListener('keydown',e=>{if(e.key==='Escape'){document.querySelector('#navigation')?.classList.remove('is-open');menu?.setAttribute('aria-expanded','false')}});
const trigger=document.querySelector('.filter-toggle'),filters=document.querySelector('#filters'),dialog=document.querySelector('#filter-dialog');
if(trigger&&filters&&dialog){const marker=document.createComment('filter position');filters.before(marker);trigger.addEventListener('click',()=>{filters.open=true;dialog.querySelector('#filter-dialog-content').append(filters);dialog.showModal();trigger.setAttribute('aria-expanded','true')});dialog.querySelector('[data-close-filters]').addEventListener('click',()=>dialog.close());dialog.addEventListener('close',()=>{marker.after(filters);trigger.setAttribute('aria-expanded','false');trigger.focus()})}
