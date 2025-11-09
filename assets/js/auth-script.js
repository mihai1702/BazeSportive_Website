


//show password login page
document.querySelectorAll('.pw-toggle').forEach(btn=>{
  btn.addEventListener('click',function(){
    const targetId=this.getAttribute('data-target');
    const input=document.getElementById(targetId);
    if(input.type==='password'){input.type='text';this.textContent='Ascunde parola';}
    else{input.type='password';this.textContent='Arată parola';}
  });
});


// register validare client-side
document.getElementById('registerForm').addEventListener('submit',function(e){
    let pw=document.getElementById('password').value;
    let pw2=document.getElementById('password2').value;
    let msgs=[];
    if(pw.length<8) msgs.push('Parola minim 8 caractere');
    if(!/[A-Z]/.test(pw)) msgs.push('Parola trebuie o literă mare');
    if(!/[a-z]/.test(pw)) msgs.push('Parola trebuie o literă mică');
    if(!/\d/.test(pw)) msgs.push('Parola trebuie o cifră');
    if(!/[\W_]/.test(pw)) msgs.push('Parola trebuie un caracter special');
    if(pw!==pw2) msgs.push('Parolele nu coincid');
    if(msgs.length){e.preventDefault();alert(msgs.join("\n"));}
});

//  show/hide password
document.querySelectorAll('.pw-toggle').forEach(btn=>{
    btn.addEventListener('click',function(){
        const targetId=this.getAttribute('data-target');
        const input=document.getElementById(targetId);
        if(input.type==='password'){input.type='text';this.textContent='Ascunde parola';}
        else{input.type='password';this.textContent='Arată parola';}
    });
});