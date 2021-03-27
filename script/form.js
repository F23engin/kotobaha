
// form
const btn = document.getElementById('btn');

btn.addEventListener('click', function() {

    const name = document.getElementById('formName');
    const mail = document.getElementById('formMail');
    const text = document.getElementById('formText');
    const contactForm = document.getElementById('contactForm');

    if ( name.value == "") {
        // name error
        alert("お名前を入力してください。");
    } else if ( mail.value == "" ) {
        // mail error
        alert("メールアドレスを正しく入力してください。");
    } else if (text.value == "") {
        // text error
        alert("お問い合わせ内容を入力してください。");
    }
})