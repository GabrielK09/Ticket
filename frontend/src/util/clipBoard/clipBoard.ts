import ClipboardJS from 'clipboard';

export function clipBoardFunction(): any { 
    return new Promise((resolve, reject) => {
        const clipboard = new ClipboardJS('.btn');

        clipboard.on('success', function() {
            clipboard.destroy();
            resolve(true);
        });

        clipboard.on('error', function(e) {
            clipboard.destroy();
            resolve(false);
        });
    });
}