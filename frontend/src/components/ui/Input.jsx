// src/components/ui/Input.js
export default function Input({ label, ...props}) {
  return (
    <div className="mb-4">
      <label htmlFor={props.id} className="block text-gray-700 mb-2">
        {label}
      </label>
      <input
        {...props}
        className="border border-gray-300 rounded-md p-2 w-full text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" // Adjust text color here
        placeholder={props.placeholder}
      />
    </div>
  );
}