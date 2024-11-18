import React, { useEffect } from "react";

interface InputFieldProps {
  id: string;
  name: string; // Add name prop
  type: string;
  placeholder: string;
  label: string;
  isError?: boolean;
  errorMessage?: string;
  value: string; // Add value to bind to form state
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void; // Handle input change
}

const Input: React.FC<InputFieldProps> = ({
  id,
  name,
  type,
  placeholder,
  label,
  isError,
  errorMessage,
  value,
  onChange,
}) => {
  useEffect(() => {
    console.log('Component mounted');
  }, []);

  return (
    <div className="mb-4">
      <label htmlFor={id} className="block text-white text-sm font-bold mb-2">
        {label}
      </label>
      <input
        id={id}
        name={name} // Pass the name prop here
        type={type}
        placeholder={placeholder}
        value={value} // Bind value to the state
        onChange={onChange} // Call onChange handler
        className={`shadow appearance-none border ${
          isError ? "border-red-500" : ""
        } rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline`} // Changed text color to text-gray-900
      />
      {isError && errorMessage && (
        <p className="text-red-500 text-xs italic">{errorMessage}</p>
      )}
    </div>
  );
};

export default Input;