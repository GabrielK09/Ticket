export function returnSuccessApi(success: boolean, message: string, data: any): any {
    return {
        success: success,
        message: message,
        data: data
    };
};

export function returnErrorApi(success: boolean, message: string, data: any): any {
    return {
        success: success,
        message: message,
        data: data
    };
};