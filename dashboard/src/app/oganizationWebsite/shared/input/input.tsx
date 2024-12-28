import React from 'react';

interface InputProps {
  id: string;
  name: string;
  type: string;
  label: string;
  required?: boolean;
  placeholder?: string;
  autoComplete?: string;
  className?: string;
  value?: string;
  onChange?: (e: React.ChangeEvent<HTMLInputElement>) => void;  // Add this line
}

const Input: React.FC<InputProps> = ({
  id,
  name,
  type,
  label,
  required = false,
  placeholder = '',
  autoComplete = '',
  className = '',
  value = '',
  onChange, // Make sure to destructure onChange
}) => {
  return (
    <div className={`space-y-2 ${className}`}>
      <label htmlFor={id} className="text-sm font-medium text-gray-900">
        {label}
      </label>
      <input
        id={id}
        name={name}
        type={type}
        value={value}
        required={required}
        placeholder={placeholder}
        autoComplete={autoComplete}
        className="w-full px-4 py-2 text-gray-900 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 transition duration-300"
        onChange={onChange} 
      />
    </div>
  );
};

export default Input;