// валидация введенных данных
export function validate() {
    setTimeout(() => false, 300);

    this.message = '';

    //--- first_name
    if (this.params.first_name.length && this.params.first_name.length > 255) {
        this.message = 'Длина имени не более 255 символов';
        return false;
    }

    //--- last_name
    if (this.params.last_name.length && this.params.last_name.length > 255) {
        this.message = 'Длина фамилии не более 255 символов';
        return false;
    }

    //--- email 
    let regex_email = /^[\w\.\d-_]+@[\w\.\d-_]+\.\w{2,4}$/i;
    if (this.params.email.length < 8 || this.params.email.length > 255) {
        this.message = 'Длина email не менее 8 и не более 255 символов';
        return false;
    } else if (!regex_email.test(this.params.email)) {
        this.message = 'Не корректный email';
        return false;
    }

    //--- telegram
    if (this.params.telegram.length < 3 || this.params.telegram.length > 32) {
        this.message = 'Длина аккаунта telegram должна быть не менее 3 и не более 32 символов';
        return false;
    }

    //--- phone
    if (this.params.phone.length && this.params.phone.length != 18) {
        this.message = 'Длина номера должна быть 18 символов';
        return false;
    }

    //---
    return true;
}