import { NextResponse } from "next/server";
import { NextRequest } from "next/server";

export default function middleware(req: NextRequest) {
  const isLoggedIn = req.cookies.get("loggedin")?.value;
  const userRole = req.cookies.get("userRole")?.value;
  const url = req.nextUrl;

  // Check if the user is logged in
  if (!isLoggedIn) {
    // If not logged in and trying to access protected route, redirect to login
    if (
      url.pathname.startsWith("/dashboard") ||
      url.pathname.startsWith("/pages/hospital") ||
      url.pathname.startsWith("/pages/userSetting")
    ) {
      return NextResponse.redirect(new URL("/auth/login", req.url));
    }
  }

  // Handle login redirection
  if (isLoggedIn && url.pathname.startsWith("/auth/login")) {
    if (userRole === "System Administrator") {
      return NextResponse.redirect(new URL("/dashboard/superAdmin/dashboard", req.url));
    }
    if (userRole === "Hospital Administrator") {
      return NextResponse.redirect(new URL("/dashboard/hospital/dashboard", req.url));
    }
  }

  // Route protection based on role for dashboard
  if (isLoggedIn && url.pathname.startsWith("/dashboard")) {
    // Protect System Admin routes
    if (userRole === "System Administrator" && !url.pathname.startsWith("/dashboard/superAdmin")) {
      return NextResponse.redirect(new URL("/dashboard/superAdmin/dashboard", req.url));
    }
    // Protect Hospital Admin routes
    if (userRole === "Hospital Administrator" && !url.pathname.startsWith("/dashboard/hospital")) {
      return NextResponse.redirect(new URL("/dashboard/hospital/dashboard", req.url));
    }
  }

  // Protect hospital-related routes
  if (isLoggedIn && url.pathname.startsWith("/pages/hospital")) {
    // Only Hospital Admins and System Admins should have access to hospital routes
    if (userRole === "System Administrator" && !url.pathname.startsWith("/pages/hospital")) {
      return NextResponse.redirect(new URL("/dashboard/superAdmin/dashboard", req.url));
    }
  }

  // Protect /pages/userSetting route for System Administrators only
  if (url.pathname.startsWith("/pages/userSetting")) {
    // If not logged in, redirect to login
    if (!isLoggedIn) {
      return NextResponse.redirect(new URL("/auth/login", req.url));
    }
    
    // Only allow access if the user is a System Administrator
    if (userRole !== "System Administrator") {
      return NextResponse.redirect(new URL("/dashboard/superAdmin/dashboard", req.url));
    }
  }

  if (url.pathname.startsWith("/pages/userRole")) {
    // If not logged in, redirect to login
    if (!isLoggedIn) {
      return NextResponse.redirect(new URL("/auth/login", req.url));
    }
    
    // Only allow access if the user is a System Administrator
    if (userRole !== "System Administrator") {
      return NextResponse.redirect(new URL("/dashboard/superAdmin/dashboard", req.url));
    }
  }

  return NextResponse.next();
}