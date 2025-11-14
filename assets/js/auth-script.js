


//show password toggle
document.querySelectorAll('.pw-toggle').forEach(btn=>{
  btn.addEventListener('click',function(){
    const targetId=this.getAttribute('data-target');
    const input=document.getElementById(targetId);
    if(input.type==='password'){input.type='text';this.textContent='Ascunde parola';}
    else{input.type='password';this.textContent='Arată parola';}
  });
});

window.onload = () => {
      document.getElementById("loading").style.display = "none";
  };