<x-app-layout>

<style>

.containerChat{
display:flex;
height:80vh;
border-radius:12px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
background:white;
}

/* SIDEBAR */

.users{
width:30%;
background:#f0f6ff;
border-right:1px solid #dbeafe;
overflow-y:auto;
}

.users h3{
background:#2563eb;
color:white;
margin:0;
padding:15px;
font-weight:600;
}

.user{
padding:14px;
cursor:pointer;
border-bottom:1px solid #e5e7eb;
transition:0.2s;
}

.user:hover{
background:#dbeafe;
}

/* CHAT */

.chat{
width:70%;
display:flex;
flex-direction:column;
background:#f9fafb;
}

#chatTitle{
background:#2563eb;
color:white;
margin:0;
padding:15px;
font-weight:600;
}

/* MENSAJES */

.messages{
flex:1;
padding:20px;
overflow-y:auto;
background:#eef2ff;
}

.message{
margin:12px 0;
display:flex;
}

.me{
justify-content:flex-end;
}

.other{
justify-content:flex-start;
}

/* BURBUJAS */

.bubble{
display:inline-block;
padding:10px 14px;
border-radius:16px;
max-width:65%;
font-size:14px;
box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

.me .bubble{
background:#2563eb;
color:white;
border-bottom-right-radius:4px;
}

.other .bubble{
background:white;
border:1px solid #e5e7eb;
border-bottom-left-radius:4px;
}

/* HORA */

.time{
font-size:11px;
margin-top:5px;
opacity:0.7;
text-align:right;
}

/* IMAGENES CHAT */

.image-container{
margin-top:6px;
max-width:230px;
overflow:hidden;
}

.chat-image{
max-width:100%;
height:auto;
border-radius:10px;
cursor:pointer;
margin-top:5px;
transition:0.2s;
}

.chat-image:hover{
transform:scale(1.02);
}

/* ARCHIVOS */

.file{
display:block;
margin-top:6px;
font-size:12px;
color:#2563eb;
text-decoration:none;
}

.file:hover{
text-decoration:underline;
}

/* PREVIEW */

#preview{
margin-top:5px;
}

/* AREA ENVIAR */

.send{
display:flex;
gap:10px;
padding:12px;
border-top:1px solid #e5e7eb;
background:white;
}

.send input[type="text"]{
flex:1;
padding:10px;
border:1px solid #d1d5db;
border-radius:8px;
outline:none;
}

.send input[type="text"]:focus{
border-color:#2563eb;
box-shadow:0 0 0 2px rgba(37,99,235,0.2);
}

.send button{
padding:10px 18px;
background:#2563eb;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
font-weight:600;
}

.send button:hover{
background:#1d4ed8;
}

/* VISOR IMAGEN */

.viewer{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.9);
display:none;
align-items:center;
justify-content:center;
z-index:9999;
}

.viewer img{
max-width:90%;
max-height:90%;
border-radius:10px;
}

.viewer span{
position:absolute;
top:20px;
right:30px;
font-size:30px;
color:white;
cursor:pointer;
}

</style>


<div class="containerChat">

<div class="users">

<h3>Usuarios</h3>

@foreach($users as $user)

<div class="user" onclick="openChat({{$user->id}},'{{$user->name}}')">
{{$user->name}}
</div>

@endforeach

</div>


<div class="chat">

<h3 id="chatTitle">Selecciona un usuario</h3>

<div id="messages" class="messages"></div>

<form id="formSend" class="send" enctype="multipart/form-data">

<input type="hidden" id="receiver_id" name="receiver_id">

<input 
type="text"
name="message"
id="message"
placeholder="Mensaje..."
>

<input type="file" name="file" id="file">

<button type="submit">
Enviar
</button>

</form>

<div id="preview"></div>

</div>

</div>


<!-- VISOR -->

<div id="viewer" class="viewer">
<span onclick="closeViewer()">✕</span>
<img id="viewerImg">
</div>


<script>

let receiver=null;

function openChat(id,name){

receiver=id;

document.getElementById('receiver_id').value=id;

document.getElementById('chatTitle').innerText=name;

loadMessages();

}

function openViewer(src){

document.getElementById('viewerImg').src=src;

document.getElementById('viewer').style.display='flex';

}

function closeViewer(){

document.getElementById('viewer').style.display='none';

}

function loadMessages(){

if(!receiver) return;

fetch('/messages/'+receiver)

.then(res=>res.json())

.then(data=>{

let html='';

data.forEach(msg=>{

let className = msg.sender_id == {{auth()->id()}} ? 'me':'other';

let date = new Date(msg.created_at);

let time = date.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});

html+=`<div class="message ${className}">
<div class="bubble">`;

if(msg.message){

html+=`<div>${msg.message}</div>`;

}

if(msg.file){

let ext = msg.file.split('.').pop().toLowerCase();

let fileUrl="/files/"+msg.file;

if(['jpg','jpeg','png','gif','webp'].includes(ext)){

html+=`
<div class="image-container">
<img src="${fileUrl}" class="chat-image" onclick="openViewer('${fileUrl}')">
</div>
`;

}

else if(ext==='pdf'){

html+=`<a class="file" href="${fileUrl}" target="_blank">📄 Ver PDF</a>`;

}

else{

html+=`<a class="file" href="${fileUrl}" target="_blank">📁 Descargar archivo</a>`;

}

}

html+=`<div class="time">${time}</div>`;

html+=`</div></div>`;

});

document.getElementById('messages').innerHTML=html;

let box=document.getElementById('messages');
box.scrollTop = box.scrollHeight;

});

}


document.getElementById('formSend').addEventListener('submit',function(e){

e.preventDefault();

if(!receiver){

alert('Selecciona un usuario primero');
return;

}

let formData=new FormData(this);

fetch('/send',{

method:'POST',

headers:{
'X-CSRF-TOKEN':'{{ csrf_token() }}'
},

body:formData

})

.then(res=>res.json())

.then(data=>{

document.getElementById('message').value='';
document.getElementById('file').value='';
document.getElementById('preview').innerHTML='';

loadMessages();

});

});


document.getElementById('file').addEventListener('change',function(){

let file=this.files[0];

if(!file) return;

let url=URL.createObjectURL(file);

let ext=file.name.split('.').pop().toLowerCase();

if(['jpg','jpeg','png','gif','webp'].includes(ext)){

document.getElementById('preview').innerHTML=
`<img src="${url}" style="max-width:120px;border-radius:8px;">`;

}else{

document.getElementById('preview').innerHTML=
`<span>${file.name}</span>`;

}

});


setInterval(loadMessages,1000);

</script>

</x-app-layout>