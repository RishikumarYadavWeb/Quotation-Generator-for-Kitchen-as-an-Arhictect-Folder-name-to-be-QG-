document.addEventListener("DOMContentLoaded",()=>{

    const password=document.getElementById("new_password");
    const confirm=document.getElementById("confirm_password");

    const strengthFill=document.getElementById("strengthFill");
    const strengthText=document.getElementById("strengthText");

    const rules={
        length:document.getElementById("ruleLength"),
        upper:document.getElementById("ruleUpper"),
        lower:document.getElementById("ruleLower"),
        number:document.getElementById("ruleNumber"),
        special:document.getElementById("ruleSpecial"),
        match:document.getElementById("ruleMatch")
    };

    function updateRule(element,status){

        if(status){

            element.classList.add("valid");
            element.querySelector("i").className="fa-solid fa-circle-check";

        }else{

            element.classList.remove("valid");
            element.querySelector("i").className="fa-solid fa-circle";

        }

    }

    function checkPassword(){

        const value=password.value;
        const confirmValue=confirm.value;

        const checks={

            length:value.length>=8,

            upper:/[A-Z]/.test(value),

            lower:/[a-z]/.test(value),

            number:/[0-9]/.test(value),

            special:/[^A-Za-z0-9]/.test(value),

            match:value!=="" && value===confirmValue

        };

        updateRule(rules.length,checks.length);
        updateRule(rules.upper,checks.upper);
        updateRule(rules.lower,checks.lower);
        updateRule(rules.number,checks.number);
        updateRule(rules.special,checks.special);
        updateRule(rules.match,checks.match);

        let score=0;

        Object.values(checks).forEach(v=>{
            if(v) score++;
        });

        let width=0;
        let color="#dc3545";
        let text="Weak";

        switch(score){

            case 0:
            case 1:
                width=20;
                color="#dc3545";
                text="Weak";
            break;

            case 2:
            case 3:
                width=45;
                color="#fd7e14";
                text="Medium";
            break;

            case 4:
            case 5:
                width=75;
                color="#0d6efd";
                text="Strong";
            break;

            case 6:
                width=100;
                color="#198754";
                text="Very Strong";
            break;

        }

        strengthFill.style.width=width+"%";
        strengthFill.style.background=color;
        strengthText.style.color=color;
        strengthText.innerText=text;

    }

    password.addEventListener("keyup",checkPassword);
    confirm.addEventListener("keyup",checkPassword);

    document.querySelectorAll(".toggle-password").forEach(button=>{

        button.addEventListener("click",function(){

            const target=document.getElementById(
                this.dataset.target
            );

            const icon=this.querySelector("i");

            if(target.type==="password"){

                target.type="text";

                icon.className="fa-solid fa-eye-slash";

            }else{

                target.type="password";

                icon.className="fa-solid fa-eye";

            }

        });

    });

});