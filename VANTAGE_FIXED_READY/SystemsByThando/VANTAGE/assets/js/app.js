document.addEventListener(
    'DOMContentLoaded',()=>{
        document.querySelectorAll('[data-auto-dismiss]').forEach(el=>setTimeout(()=>el.remove(),5000));
    });
