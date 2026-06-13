import { split, join } from 'shamir';

const secrets = {
    random: (bits) => {
        const bytes = bits / 8;
        const array = new Uint8Array(bytes);
        window.crypto.getRandomValues(array);
        return Array.from(array).map(b => b.toString(16).padStart(2, '0')).join('');
    },
    share: (secretHex, n, k) => {
        const hexMatches = secretHex.match(/.{1,2}/g);
        if (!hexMatches) throw new Error("Invalid hex string for secret");
        
        const secret = new Uint8Array(hexMatches.map(byte => parseInt(byte, 16)));
        
        const randomBytes = (len) => {
            const array = new Uint8Array(len);
            window.crypto.getRandomValues(array);
            return array;
        };

        const parts = split(randomBytes, n, k, secret);
        
        return Object.entries(parts).map(([id, data]) => {
            const idHex = parseInt(id).toString(16).padStart(2, '0');
            const dataHex = Array.from(data).map(b => b.toString(16).padStart(2, '0')).join('');
            return idHex + dataHex;
        });
    },
    combine: (shares) => {
        const parts = {};
        shares.forEach(share => {
            if (!share || share.length < 2) return;
            const id = parseInt(share.substring(0, 2), 16);
            const dataHex = share.substring(2);
            const dataMatches = dataHex.match(/.{1,2}/g);
            if (dataMatches) {
                parts[id] = new Uint8Array(dataMatches.map(byte => parseInt(byte, 16)));
            }
        });
        
        if (Object.keys(parts).length === 0) throw new Error("No valid shares provided");
        
        const secret = join(parts);
        return Array.from(secret).map(b => b.toString(16).padStart(2, '0')).join('');
    }
};

window.secrets = secrets;
console.log('SSS Library (Shamir) initialized');
