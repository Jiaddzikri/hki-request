import { join } from 'shamir';

const shares = [
    "03d232aa167542e8e9f606250e0dcefb01f7d6aaef7f2d9fb034929cd1114510a3",
    "0279c07e6fc8634a50afc34c44b62836e4f4072d036d1bafb3f4f7d00450768750"
];

const parts = {};
shares.forEach(share => {
    const id = parseInt(share.substring(0, 2), 16);
    const dataHex = share.substring(2);
    const dataMatches = dataHex.match(/.{1,2}/g);
    parts[id] = new Uint8Array(dataMatches.map(byte => parseInt(byte, 16)));
});

const secret = join(parts);
const secretHex = Array.from(secret).map(b => b.toString(16).padStart(2, '0')).join('');
console.log("Reconstructed Secret Hex:", secretHex);

// Calculate hash to match DB
import crypto from 'crypto';
const hash = crypto.createHash('sha256').update(secretHex).digest('hex');
console.log("Secret Hash (SHA-256):", hash);
