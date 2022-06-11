$(document).foundation()

function check_login() {
    const email = document.loginForm.email.value;
    const password = document.loginForm.password.value;

    const dotpos = email.lastIndexOf(".");
    const atpos = email.lastIndexOf("@");
    const strlen = email.length;

    if (atpos < 1 || dotpos - atpos < 2 || strlen - dotpos < 3) {
        alert('Invalid email address format');
        return false;
    }

    if(password == ""){
        alert('Password empty');
        return false;
    }

    return true;
}

function check_signin() {
    const username = document.signinForm.username.value;
    const email = document.signinForm.email.value;
    const phone = document.signinForm.phone.value;
    const password = document.signinForm.password.value;
    const birth = document.signinForm.birth.value;
    const gender = document.signinForm.gender.value;

    if(username == ""){
        alert('Username empty');
        return false;
    }

    const dotpos = email.lastIndexOf(".");
    const atpos = email.lastIndexOf("@");
    const strlen = email.length;

    if (atpos < 1 || dotpos - atpos < 2 || strlen - dotpos < 3) {
        alert('Invalid email address format');
        return false;
    }

    if(phone == ""){
        alert('Phone empty');
        return false;
    }


    if(password == ""){
        alert('Password empty');
        return false;
    }

    if(birth == ""){
        alert('Date of birth empty');
        return false;
    }

    if(gender == ""){
        alert('Please select a gender');
        return false;
    }

    return true;
}

function checkCreatePost() {
    const title = document.createPost.title.value;
    const date = document.createPost.date.value;
    const location = document.createPost.location.value;
    const description = document.createPost.description.value;

    if(title == ""){
        alert('Title can not be empty');
        return false;
    }

    if(date == ""){
        alert('Date can not be empty');
        return false;
    }

    if(location == ""){
        alert('Location can not be empty');
        return false;
    }

    if(description == ""){
        alert('Description can not empty');
        return false;
    }

    return true;
}

function checkModifyPost() {
    const title = document.modifyPost.title.value;
    const date = document.modifyPost.date.value;
    const location = document.modifyPost.location.value;
    const description = document.modifyPost.description.value;

    if(title == ""){
        alert('Title can not be empty');
        return false;
    }

    if(date == ""){
        alert('Date can not be empty');
        return false;
    }

    if(location == ""){
        alert('Location can not be empty');
        return false;
    }

    if(description == ""){
        alert('Description can not empty');
        return false;
    }

    return true;
}