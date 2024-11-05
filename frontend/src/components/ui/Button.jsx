// src/components/ui/Button.js
const Button = ({ children, type = 'button', className, disabled, ...props }) => {
  return (
    <button
      type={type}
      disabled={disabled}
      className={`bg-blue-500 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-blue-600 ${
        disabled ? 'opacity-50 cursor-not-allowed' : ''
      } ${className}`}
      {...props}
    >
      {children}
    </button>
  );
};

export default Button;