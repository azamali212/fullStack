import React, { useState, useEffect } from "react";
import { useDispatch } from "react-redux";
import { updatePermission } from "@/lib/slice/userPermissionSlice";
import { AppDispatch } from "@/lib/store";
import {
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  Button,
  TextField,
} from "@mui/material";

interface EditPermissionModalProps {
  open: boolean;
  handleClose: () => void;
  onPermissionUpdated: () => void;
  permissionToEdit: { id: number; name: string; group: string };
}

const EditPermissionModal: React.FC<EditPermissionModalProps> = ({
  open,
  handleClose,
  onPermissionUpdated,
  permissionToEdit,
}) => {
  const [permissionName, setPermissionName] = useState(
    permissionToEdit?.name || ""
  );
  const [newPermissionGroup, setNewPermissionGroup] = useState(
    permissionToEdit?.group || ""
  );
  const dispatch = useDispatch<AppDispatch>();

  useEffect(() => {
    if (open && permissionToEdit) {
      setPermissionName(permissionToEdit.name);
      setNewPermissionGroup(permissionToEdit.group);
    }
  }, [open, permissionToEdit]);

  const handleSubmit = () => {
    if (permissionName.trim() && newPermissionGroup.trim()) {
      const updatedPermissionData = {
        name: permissionName,
        group: newPermissionGroup,
      };

      dispatch(
        updatePermission({
          permission: parseInt(permissionToEdit.id),
          permissionData: updatedPermissionData,
        })
      )
        .unwrap()
        .then(() => {
          onPermissionUpdated();
          handleClose();
        })
        .catch((error) => console.error("Error updating permission:", error));
    } else {
      console.error("Name and group must be provided");
    }
  };

  return (
    <div
      className={`fixed inset-0 flex items-center justify-center z-50 transition-all ${
        open ? "opacity-100" : "opacity-0 pointer-events-none"
      } bg-black bg-opacity-50`}
    >
      <div
        className={`bg-white w-full max-w-lg p-8 rounded-lg shadow-lg transition-all transform ${
          open ? "scale-100 opacity-100" : "scale-95 opacity-0"
        }`}
      >
        <DialogTitle className="text-center text-xl font-semibold text-gray-700">
          Edit Permission
        </DialogTitle>
        <DialogContent className="space-y-4">
          <TextField
            fullWidth
            label="Permission Name" // Ensure label is always visible
            value={permissionName}
            onChange={(e) => setPermissionName(e.target.value)}
            variant="standard" 
            className="transition-all duration-300 ease-in-out"
            sx={{
              "& .MuiOutlinedInput-root": {
                "&:hover fieldset": {
                  borderColor: "#3f51b5", // Hover effect for input field
                },
              },
            }}
          />
          <TextField
            fullWidth
            label="Permission Group"
            value={newPermissionGroup}
            onChange={(e) => setNewPermissionGroup(e.target.value)}
            variant="standard" 
            className="transition-all duration-300 ease-in-out"
            sx={{
              "& .MuiOutlinedInput-root": {
                "&:hover fieldset": {
                  borderColor: "#3f51b5", // Hover effect for input field
                },
              },
            }}
          />
        </DialogContent>
        <DialogActions className="justify-between">
          <Button
            onClick={handleClose}
            color="secondary"
            className="transition-all duration-300 ease-in-out hover:bg-gray-200"
          >
            Cancel
          </Button>
          <Button
            onClick={handleSubmit}
            color="primary"
            className="transition-all duration-300 ease-in-out hover:bg-blue-600 hover:text-white focus:bg-blue-600 focus:text-white"
          >
            Save
          </Button>
        </DialogActions>
      </div>
    </div>
  );
};

export default EditPermissionModal;
