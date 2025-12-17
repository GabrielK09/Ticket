export function validatePassword (password: string): string|boolean {
    const specialChars = '`!@#$^&;:?~';

    if(password === '') return 'A senha precisa ser informada!';
    if(password.length < 8) return 'A senha precisa conter pelo menos 8 caracteres!';
    if(!password.split('').some(char => specialChars.includes(char))) return 'A senha precisa conter ao menos 1 caracter especial!';

    return true;
};

export function validateEmail(email: string): string|boolean {
    if(email === '') return 'O e-mail precisa ser informado!';
    if(!email.split('').includes('@') || email.split('@')[1] === '') return 'O e-mail precisa estar em um formato válido!';

    return true;  
};