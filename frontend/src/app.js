const API = '/backend/public/index.php?route=';
let currentGroup = null, lastFootprint = 0, pollTimer = null;
const $ = id => document.getElementById(id);
async function api(route, options = {}) { const res = await fetch(API + route, {headers:{'Content-Type':'application/json'}, credentials:'include', ...options}); if(!res.ok) throw new Error((await res.json()).error || 'Request failed'); return res.json(); }
async function login(){ await api('auth/login',{method:'POST',body:JSON.stringify({username:$('username').value,password:$('password').value})}); $('login').hidden=true; $('chat').hidden=false; await loadGroups(); startPolling(); }
async function loadGroups(){ const data=await api('groups'); $('groups').innerHTML=''; data.groups.forEach(g=>{const li=document.createElement('li'); const b=document.createElement('button'); b.textContent=g.name; b.onclick=()=>selectGroup(g); li.appendChild(b); $('groups').appendChild(li);}); }
async function selectGroup(g){ currentGroup=g; $('groupTitle').textContent=g.name; const data=await api(`groups/${g.id}/messages`); $('messages').innerHTML=''; data.messages.forEach(addMessage); }
function addMessage(m){ const d=document.createElement('div'); d.className='msg'; d.textContent=`${m.username}: ${m.body}`; $('messages').appendChild(d); $('messages').scrollTop=$('messages').scrollHeight; }
async function send(e){ e.preventDefault(); if(!currentGroup) return; await api(`groups/${currentGroup.id}/messages`,{method:'POST',body:JSON.stringify({body:$('messageInput').value})}); $('messageInput').value=''; await selectGroup(currentGroup); }
async function poll(){ try{ const data=await api(`poll&after_id=${lastFootprint}`); data.footprints.forEach(f=>{lastFootprint=Math.max(lastFootprint, Number(f.id)); if(currentGroup && Number(f.group_id)===Number(currentGroup.id)) selectGroup(currentGroup);}); }catch(e){} }
function startPolling(){ if(pollTimer) clearInterval(pollTimer); pollTimer=setInterval(poll,3000); }
$('loginBtn').onclick=login; $('logoutBtn').onclick=async()=>{await api('auth/logout',{method:'POST'}); location.reload();}; $('sendForm').onsubmit=send; $('newGroupBtn').onclick=async()=>{const name=prompt('Group name'); if(name){await api('groups',{method:'POST',body:JSON.stringify({name})}); loadGroups();}};
if('serviceWorker' in navigator) navigator.serviceWorker.register('../service-worker.js');
api('me').then(()=>{ $('login').hidden=true; $('chat').hidden=false; loadGroups(); startPolling(); }).catch(()=>{});
