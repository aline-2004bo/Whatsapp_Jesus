<x-app-layout>

<style>

.containerChat{
display:flex;
height:80vh;
border:1px solid #ccc;
}

.users{
width:30%;
border-right:1px solid #ccc;
overflow-y:auto;
}

.user{
padding:15px;
cursor:pointer;
border-bottom:1px solid #eee;
}

.user:hover{
background:#f5f5f5;
}

.chat{
width:70%;
display:flex;
flex-direction:column;
}

.messages{
flex:1;
padding:10px;
overflow-y:auto;
background:#fafafa;
}

.message{
margin:10px 0;
}

.me{
text-align:right;
}

.other{
text-align:left;
}

.bubble{
display:inline-block;
padding:10px;
border-radius:10px;
background:#dcf8c6;
max-width:60%;
}

.other .bubble{
background:#fff;
border:1px solid #ddd;
}

.file{
display:block;
margin-top:5px;
font-size:12px;
}

.send{
display:flex;
gap:10px;
padding:10px;
border-top:1px solid #ccc;
}

</style>


<div class="containerChat">

<div class="users">

<h3 style="padding:10px">Usuarios</h3>

@foreach($users as $user)

<div class="user" onclick="openChat({{$user->id}},'{{$user->name}}')">
{{$user->name}}
</div>

@endforeach

</div>


<div class="chat">

<h3 id="chatTitle" style="padding:10px">Selecciona un usuario</h3>

<div id="messages" class="messages"></div>

<form id="formSend" class="send" enctype="multipart/form-data">

<input type="hidden" id="receiver_id" name="receiver_id">

<input 
type="text"
name="message"
id="message"
placeholder="Mensaje..."
style="flex:1;padding:8px;border:1px solid #ccc;border-radius:5px"
>

<input type="file" name="file" id="file">

<button type="submit"
style="padding:8px 15px;background:#4CAF50;color:white;border:none;border-radius:5px">
Enviar
</button>

</form>

</div>

</div>


<script>

let receiver=null;

function openChat(id,name){

receiver=id;

document.getElementById('receiver_id').value=id;

document.getElementById('chatTitle').innerText=name;

loadMessages();

}

function loadMessages(){

if(!receiver) return;

fetch('/messages/'+receiver)

.then(res=>res.json())

.then(data=>{

let html='';

data.forEach(msg=>{

let className = msg.sender_id == {{auth()->id()}} ? 'me':'other';

html+=`<div class="message ${className}">
<div class="bubble">${msg.message ?? ''}</div>`;

if(msg.file){

html+=`<a class="file" href="/files/${msg.file}" target="_blank">Archivo</a>`;

}

html+=`</div>`;

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

loadMessages();

})

.catch(error=>{
console.log(error);
alert('Error enviando mensaje');
});

});

setInterval(loadMessages,2000);

</script>

</x-app-layout>