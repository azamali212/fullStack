import { NextResponse } from 'next/server';

export function middleware(req) {
    const token = req.cookies.get('token'); 

    if (!token) {
        return NextResponse.redirect(new URL('/pages/login', req.url)); // Redirect to login if no token
    }
    return NextResponse.next(); // Allow access if authenticated
}

export const config = {
    matcher: ['/auth-page/dashboard/:path*', '/auth-page/home/:path*'], // Match the home page as well
};