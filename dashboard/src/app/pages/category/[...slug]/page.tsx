import { useRouter } from 'next/router';

const CategoryPage = () => {
  const { query } = useRouter();
  const slug = query.slug;

  // Ensure slug is an array before joining
  const slugPath = Array.isArray(slug) ? slug.join(" > ") : slug;

  return (
    <div>
      <h1>Category: {slugPath}</h1>
      <p>Displaying products or information for category: {slugPath}</p>
    </div>
  );
};

export default CategoryPage;