import BasicBreadcrumbs from '@/app/ui/breadcrumbs/breadcrumbs';
import { useRouter } from 'next/router';
 // Your Breadcrumbs component

const DynamicPage = () => {
  const router = useRouter();

  // Wait for the router to be ready
  if (!router.isReady) {
    return <div>Loading...</div>;
  }

  const { slug } = router.query;
  console.log("Slug from router:", slug);

  // If slug is not available yet, return loading state
  if (!slug) {
    return <div>Loading...</div>;
  }

  // Ensure that slug is an array, even if it's just a string
  const path = Array.isArray(slug) ? slug : [slug];
  console.log("Path for breadcrumbs:", path);

  // Simulate a 404 page logic (add logic for invalid slugs here)
  const isValidSlug = path.length > 0;

  if (!isValidSlug) {
    return <div>No breadcrumbs available</div>;
  }

  return (
    <div className="p-4">
      {/* Breadcrumbs Component */}
      <div className="mb-4">
        <BasicBreadcrumbs path={path} />
      </div>

      <h1 className="text-2xl font-bold mb-4">{path.join(' / ')}</h1>
      <p>
        This is a dynamically generated page for the path: 
        <code>{path.join('/')}</code>
      </p>
    </div>
  );
};

export default DynamicPage;