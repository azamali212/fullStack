import Link from 'next/link';

const Custom404 = () => (
  <div className="text-center py-10">
    <h1 className="text-4xl font-bold">404 - Page Not Found</h1>
    <p className="mt-4">The page you are looking for does not exist.</p>
    <Link href="/" className="mt-4 text-blue-600 underline">
      Go back to Home
    </Link>
  </div>
);

export default Custom404;