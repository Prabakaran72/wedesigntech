const regEx={
    email : /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    mobile_no : /^\d{10}$/,
    phone_no : /^(\(\d{3}\) |\d{3}[-.\s]?)(\d{3}[-.\s]?)\d{4}$/,
    date : /^(0[1-9]|[12][0-9]|3[01])(0[1-9]|1[0-2])\d{4}$/, //DDMMYYYY format 
    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,15}$/
}
function isValidEmailId(value){
    return regEx.email.test(value);
}
function isValidMobileNo(value){
    return regEx.mobile_no.test(value);
}
function isValidDate(value){
    return regEx.date.test(value);
}
function isValidPassword(value){
    return regEx.password.test(value);
}
function isEmpty(value){
    return value.trim() =='' || value.trim() ==null || value.trim() == undefined;
}