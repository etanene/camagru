export function validateLogin(login) {
    const res = /^[A-Za-z\d]{4,12}$/.exec(login);

    return res ? true : false;
}

export function validatePassword(passwd) {
    const res = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{4,16}$/.exec(passwd);

    return res ? true : false;
}

export function validateEmail(email) {
    const res = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.exec(email);

    return res ? true : false;
}
