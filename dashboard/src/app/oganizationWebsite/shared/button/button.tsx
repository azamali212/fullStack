import React from 'react';
import { ReactNode } from 'react';

interface ButtonProps {
  type?: 'button' | 'submit' | 'reset'; // Type of the button
  text: string; // Button text
  icon?: ReactNode; // Icon element (optional)
  onClick?: () => void; // onClick handler (optional)
  className?: string; // Additional classes (optional)
  isFullWidth?: boolean; // Whether the button should be full-width (optional)
  disabled?: boolean;
}

const Button: React.FC<ButtonProps> = ({
  type = 'button', // default value for type is 'button'
  text,
  icon,
  onClick,
  className = '',
  isFullWidth = false,
  disabled = false, 
}) => {
  return (
    <button
      type={type}
      onClick={onClick}
      className={`w-full ${isFullWidth ? 'py-2' : 'py-1'} ${className} flex items-center justify-center border border-gray-300 rounded-md shadow-sm text-gray-900 hover:bg-gray-100 focus:ring-2 focus:ring-indigo-600 transition duration-300`}
    >
      {icon && <span className="mr-2">{icon}</span>}
      {text}
    </button>
  );
};

export default Button;