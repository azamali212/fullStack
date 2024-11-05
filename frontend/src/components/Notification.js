export default function Notification({ message, type, onClose }) {
    const notificationClasses = {
        success: 'bg-green-500',
        error: 'bg-red-500',
      };
    
      return (
        <div
          className={`fixed top-5 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded shadow-lg text-white ${notificationClasses[type]}`}
          style={{ zIndex: 9999 }}
        >
          {message}
          <button
            onClick={onClose}
            className="ml-4 font-bold underline"
          >
            Close
          </button>
        </div>
      );
}