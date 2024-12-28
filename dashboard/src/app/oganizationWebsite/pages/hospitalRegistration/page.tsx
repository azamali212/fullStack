"use client";

import { useState, useEffect, useRef } from "react";
import { Dialog, DialogPanel } from "@headlessui/react";
import { Bars3Icon, XMarkIcon } from "@heroicons/react/24/outline";
import { Link as ScrollLink, Element } from "react-scroll";
import dynamic from "next/dynamic";
import { Typed } from "react-typed";
import Image from "next/image";
import Link from "next/link";
import { useSelector, useDispatch } from "react-redux";
import { AppDispatch } from "@/lib/store";
import { performLogout } from "@/lib/slice/organizationWebsite/hospitalRegistrationUser/hospitalRegistration";
import { RootState } from "@/lib/store";
import { useRouter } from "next/navigation";

// Dynamically imported sections
const About = dynamic(() => import("../about/page"));
const Payment = dynamic(() => import("../pricing/page"));
const Blog = dynamic(() => import("../blog/page"));
const OurTeam = dynamic(() => import("../team/page"));
const Contact = dynamic(() => import("../contact/page"));
const Trusted = dynamic(() => import("../trusted/page"));
const Footer = dynamic(() => import("../footer/page"));

const navigation = [
  { name: "About", to: "about" },
  { name: "Our Team", to: "team" },
  { name: "Pricing", to: "pricing" },
  { name: "Contact", to: "contact" },
  { name: "Blog", to: "blog" },
  { name: "Footer", to: "footer" },
];

// Wrapper for Typed component
const TypedWrapper = (props: any) => {
  const { strings, typeSpeed, backSpeed, loop } = props;
  const typedElement = useRef(null);
  const [startTyping, setStartTyping] = useState(false);

  useEffect(() => {
    setTimeout(() => setStartTyping(true), 1000); // Delay typing for 1 second
  }, []);

  useEffect(() => {
    if (startTyping) {
      new Typed(typedElement.current, { strings, typeSpeed });
    }
  }, [startTyping, strings, typeSpeed, backSpeed, loop]);

  return <span ref={typedElement} />;
};

export default function Home() {
  const router = useRouter();
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const dispatch = useDispatch<AppDispatch>();
  const { token } = useSelector((state: RootState) => state.hospitalRegistration);

  // Ensure token is read from localStorage if not in Redux state
  const tokenFromLocalStorage = typeof window !== 'undefined' ? localStorage.getItem('token') : null;
  const finalToken = token || tokenFromLocalStorage;

  // Redirect to login page if token is missing, after storing the current route
  useEffect(() => {
    if (!finalToken) {
      // Store the current route so we can redirect the user back after login
      localStorage.setItem('redirectRoute', window.location.pathname);
      router.push("/oganizationWebsite/auth/signIn");
    }
  }, [finalToken, router]);

  // Sync token from localStorage to Redux state after login
  useEffect(() => {
    if (tokenFromLocalStorage && !token) {
      dispatch({ type: 'hospitalRegistration/setToken', payload: tokenFromLocalStorage }); 
    }
  }, [dispatch, token, tokenFromLocalStorage]);

  // Logout handler
  const handleLogout = async () => {
    try {
      await dispatch(performLogout());
      localStorage.removeItem("token"); // Remove token from localStorage on logout
      router.push("/oganizationWebsite/auth/signIn");
    } catch (error) {
      console.error("Logout failed:", error);
    }
  };

  // Handle the login redirect after successful login
  useEffect(() => {
    const redirectRoute = localStorage.getItem('redirectRoute');
    if (redirectRoute) {
      localStorage.removeItem('redirectRoute');
      router.push(redirectRoute);
    }
  }, [router]);

  return (
    <main className="bg-[var(--website-primary-color)]">
      <div className="bg-[var(--website-primary-color)]">
        {/* Header */}
        <header className="fixed inset-x-0 top-0 z-50 bg-[var(--website-nav-color)] text-black shadow-md">
          <nav aria-label="Global" className="flex items-center justify-between p-6 lg:px-8">
            {/* Logo */}
            <div className="flex lg:flex-1">
              <a href="#" className="-m-1.5 p-1.5">
                <span className="sr-only">Your Company</span>
                <Image
                  src="/images/newlogo.png"
                  alt="Company Logo"
                  width={40}
                  height={40}
                  className="rounded-full"
                />
              </a>
            </div>

            {/* Mobile Menu Toggle */}
            <div className="flex lg:hidden">
              <button
                type="button"
                onClick={() => setMobileMenuOpen(true)}
                className="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
              >
                <span className="sr-only">Open main menu</span>
                <Bars3Icon className="h-6 w-6" aria-hidden="true" />
              </button>
            </div>

            {/* Desktop Navigation Links */}
            <div className="hidden lg:flex lg:gap-x-12">
              {navigation.map((item) => (
                <ScrollLink
                  key={item.name}
                  to={item.to}
                  smooth
                  duration={500}
                  offset={-70}
                  className="text-sm font-semibold text-[var(--website-navtext-color)] cursor-pointer"
                >
                  {item.name}
                </ScrollLink>
              ))}
            </div>

            {/* Login/Logout Button */}
            <div className="hidden lg:flex lg:flex-1 lg:justify-end">
              {finalToken ? (
                <button
                  onClick={handleLogout}
                  className="text-sm font-semibold text-[var(--website-navtext-color)]"
                >
                  Logout
                </button>
              ) : (
                <Link
                  href="/oganizationWebsite/auth/signIn"
                  className="text-sm font-semibold text-[var(--website-navtext-color)]"
                >
                  Log in <span aria-hidden="true">&rarr;</span>
                </Link>
              )}
            </div>
          </nav>

          {/* Mobile Menu */}
          <Dialog open={mobileMenuOpen} onClose={() => setMobileMenuOpen(false)} className="lg:hidden">
            <div className="fixed inset-0 z-50" />
            <DialogPanel className="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
              <div className="flex items-center justify-between">
                <button
                  type="button"
                  onClick={() => setMobileMenuOpen(false)}
                  className="-m-2.5 rounded-md p-2.5 text-gray-700"
                >
                  <span className="sr-only">Close menu</span>
                  <XMarkIcon className="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <div className="mt-6 flow-root">
                <div className="-my-6 divide-y divide-gray-500/10">
                  <div className="space-y-2 py-6">
                    {navigation.map((item) => (
                      <ScrollLink
                        key={item.name}
                        to={item.to}
                        smooth
                        duration={500}
                        offset={-70}
                        className="block rounded-lg px-4 py-4 text-base font-semibold text-gray-900 hover:bg-gray-50 cursor-pointer"
                        onClick={() => setMobileMenuOpen(false)}
                      >
                        {item.name}
                      </ScrollLink>
                    ))}
                  </div>
                </div>
              </div>
            </DialogPanel>
          </Dialog>
        </header>

        {/* Main Section */}
        <main className="relative isolate px-6 pt-14 lg:px-8">
          {/* Hero Section */}
          <div className="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56 text-center">
            <h1 className="text-4xl sm:text-6xl font-semibold text-gray-900" style={{ minHeight: "20vh" }}>
              <TypedWrapper
                strings={[
                  "Data to enrich your online business",
                  "Boost your productivity with our tools",
                  "Simplify and manage workflows effortlessly",
                ]}
                typeSpeed={40}
                backSpeed={50}
                loop
              />
            </h1>
            <p className="mt-6 text-lg leading-8 text-gray-600">
              Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.
            </p>
            <div className="mt-10 flex justify-center gap-x-6">
              <a
                href="#"
                className="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
              >
                Get started
              </a>
              <a href="#" className="text-sm font-semibold text-gray-900">
                Learn more <span aria-hidden="true">→</span>
              </a>
            </div>
          </div>

          {/* Dynamic Sections */}
          <Element name="about">
            <About />
          </Element>
          <Element name="team">
            <OurTeam />
          </Element>
          <Element name="pricing">
            <Payment />
          </Element>
          <Element name="contact">
            <Contact />
          </Element>
          <Element name="blog">
            <Blog />
          </Element>
          <Element name="trusted">
            <Trusted />
          </Element>
          <Element name="footer">
            <Footer />
          </Element>
        </main>
      </div>
    </main>
  );
}