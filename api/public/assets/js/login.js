'use strict';
const frm = document.forms['form-login'];

frm.addEventListener('submit', e => {
    e.preventDefault();
    
    try {
        let auth = await fetch('http://127.0.0.1:8000/api/login', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json'
            },
            body: JSON.stringify(sfrmData)
        });
        // if response
        let json = await auth.json();
        console.log(json);
    }
    catch(err) 
    {

    }
});
