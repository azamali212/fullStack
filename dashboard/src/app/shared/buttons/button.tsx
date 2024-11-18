'use client'
import React,{useEffect} from "react";

interface ButtonProps {
  text: string;
  onClick?: () => void;
  disabled: boolean; // Corrected to boolean
}

const Button: React.FC<ButtonProps> = ({ text, onClick, disabled }) => {
  useEffect(() => {
    console.log('Component mounted');
  }, []);
  return (
    <button
      className="bg-white hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
      type="submit"
      disabled={disabled} // Use the correct disabled prop
      onClick={onClick}
    >
      {text}
    </button>
  );
};

export default Button;