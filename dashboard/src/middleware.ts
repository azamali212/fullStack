import { NextResponse } from "next/server";
import { NextRequest } from "next/server";

export default function middleware(req: NextRequest) {
  const isLoggedIn = req.cookies.get("loggedin")?.value;
  const userRole = req.cookies.get("userRole")?.value;
  const url = req.url;

  // Ensure the cookie values are compared as strings
  if (!isLoggedIn && url.includes("/dashboard")) {
    return NextResponse.redirect("http://localhost:3000/auth/login");
  }

  if (isLoggedIn && url.includes("/auth/login")) {
    if (userRole === "System Administrator") {
      return NextResponse.redirect("http://localhost:3000/dashboard/superAdmin/dashboard");
    }
    if (userRole === "Hospital Administrator") {
      return NextResponse.redirect("http://localhost:3000/dashboard/hospital/dashboard");
    }
  }

  return NextResponse.next();
}