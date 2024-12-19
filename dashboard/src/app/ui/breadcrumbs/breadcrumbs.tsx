import { Breadcrumbs, Link, Typography } from "@mui/material";
import { usePathname } from "next/navigation";

const BasicBreadcrumbs = () => {
  const pathname = usePathname();

  const getBreadcrumbs = () => {
    const pathSegments = pathname.split("/").filter(Boolean);
  
    return pathSegments.map((segment, index) => {
      const readableTitle = segment.charAt(0).toUpperCase() + segment.slice(1);
      const isLast = index === pathSegments.length - 1;
  
      // Generate URLs dynamically for each breadcrumb
      const href = `/${pathSegments.slice(0, index + 1).join("/")}/userSetting`;
  
      return isLast ? (
        <Typography
          key={index}
          sx={{ fontWeight: 600, color: "text.primary" }}
        >
          {readableTitle}
        </Typography>
      ) : (
        <Link
          key={index}
          underline="hover"
          color="inherit"
          href={href}
          className="text-sm sm:text-base text-gray-700 hover:text-blue-600"
        >
          {readableTitle}
        </Link>
      );
    });
  };

  return (
    <div className="bg-gray-100 py-2 px-4 rounded-lg shadow-md sticky top-16 z-20">
      <Breadcrumbs
        aria-label="breadcrumb"
        maxItems={2}
        separator="›"
        className="flex justify-center space-x-2"
        sx={{
          "& .MuiBreadcrumbs-separator": {
            color: "gray",
          },
        }}
      >
        {/* Home Link */}
        <Link
          color="inherit"
          href="/"
          className="text-sm sm:text-base text-gray-700 hover:text-blue-600"
        >
          Home
        </Link>

        {/* Dynamically generated breadcrumbs */}
        {getBreadcrumbs()}
      </Breadcrumbs>
    </div>
  );
};

export default BasicBreadcrumbs;