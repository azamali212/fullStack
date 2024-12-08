import React from 'react';

interface DeletePermissionModalProps {
  open: boolean;
  handleClose: () => void;
  handleDelete: () => void;
  permissionName: string;
}

const DeletePermissionModal: React.FC<DeletePermissionModalProps> = ({
  open,
  handleClose,
  handleDelete,
  permissionName,
}) => {
  if (!open) return null;

  return (
    <div className="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
      <div className="bg-white w-96 p-6 rounded-lg shadow-lg space-y-4">
        <h2 className="text-xl font-semibold text-center text-gray-700">
          Are you sure you want to delete the permission "{permissionName}"?
        </h2>
        <div className="flex justify-between">
          <button
            onClick={handleClose}
            className="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none"
          >
            Cancel
          </button>
          <button
            onClick={() => {
              handleDelete();
              handleClose();
            }}
            className="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  );
};

export default DeletePermissionModal;