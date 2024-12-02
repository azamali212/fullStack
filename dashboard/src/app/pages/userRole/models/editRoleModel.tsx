'use client'
import React, { useState, useEffect } from "react";
import {
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  Button,
  TextField,
  Grid,
  Typography,
  FormControl,
  InputLabel,
  Select,
  MenuItem,
  Checkbox,
  ListItemText,
} from "@mui/material";
import { useDispatch, useSelector } from "react-redux";
import { fetchPermissions } from "@/lib/slice/userPermissionSlice";
import { updateRole } from "@/lib/slice/userRoleSlice";
import { AppDispatch, RootState } from "@/lib/store";
import { SelectChangeEvent } from "@mui/material/Select";

interface EditRoleModalProps {
  open: boolean;
  handleClose: () => void;
  onRoleUpdated: () => void;
  roleToEdit: { id: number; name: string; permissions: number[] };
}

const EditRoleModal: React.FC<EditRoleModalProps> = ({
  open,
  handleClose,
  onRoleUpdated,
  roleToEdit,
}) => {
  const [roleName, setRoleName] = useState(roleToEdit?.name || "");
  const [permissions, setPermissions] = useState(roleToEdit?.permissions || []);

  const dispatch = useDispatch<AppDispatch>();
  const { permissions: availablePermissions, loading, error } = useSelector(
    (state: RootState) => state.userPermission
  );

  useEffect(() => {
    if (open) {
      dispatch(fetchPermissions());
    }
  }, [open, dispatch]);

  useEffect(() => {
    if (open && roleToEdit) {
      setRoleName(roleToEdit.name);
      setPermissions(roleToEdit.permissions || []); // Pre-select existing permissions
      console.log("Loaded permissions:", roleToEdit.permissions);
    }
  }, [open, roleToEdit]);

  const handlePermissionsChange = (e: SelectChangeEvent<number[]>) => {
    setPermissions(e.target.value as number[]);
  };

  const handleSubmit = () => {
    if (roleName.trim() && permissions.length > 0) {
      console.log("Submitting with roleData:", {
        name: roleName,
        permission: permissions,
      });

      // Modify the permissions to send the names instead of IDs
      const permissionNames = availablePermissions
        .filter((permission) => permissions.includes(permission.id)) // Filter permissions that are selected
        .map((permission) => permission.name); // Get the permission names

      // Dispatch the updateRole action with permission names
      dispatch(
        updateRole({
          role: roleToEdit.id,
          roleData: { name: roleName, permission: permissionNames }, // Send permission names
        })
      )
        .unwrap()
        .then(() => {
          setPermissions([]); // Clear permissions after updating
          onRoleUpdated(); // Trigger the parent refresh
          handleClose(); // Close the modal
        })
        .catch((error) => {
          console.error("Error updating role:", error);
        });
    } else {
      console.error("Role name or permissions are invalid");
    }
  };

  if (!roleToEdit) return null;

  // Debugging: Check roleToEdit and permissions state
  console.log("roleToEdit:", roleToEdit);
  console.log("permissions state:", permissions);

  return (
    <Dialog open={open} onClose={handleClose}>
      <DialogTitle>Edit Role</DialogTitle>
      <DialogContent>
        <Grid container spacing={2}>
          <Grid item xs={12}>
            <TextField
              fullWidth
              label="Role Name"
              value={roleName}
              onChange={(e) => setRoleName(e.target.value)}
              variant="outlined"
              required
            />
          </Grid>
          <Grid item xs={12}>
            <Typography variant="subtitle1">Permissions</Typography>
            {loading ? (
              <Typography>Loading permissions...</Typography>
            ) : error ? (
              <Typography color="error">{error}</Typography>
            ) : (
              <FormControl fullWidth variant="outlined">
                <InputLabel>Permissions</InputLabel>
                <Select
                  multiple
                  value={permissions}
                  onChange={handlePermissionsChange}
                  label="Permissions"
                  renderValue={(selected) => {
                    const selectedPermissions = availablePermissions.filter(
                      (permission) => selected.includes(permission.id)
                    );
                    return selectedPermissions
                      .map((permission) => permission.name)
                      .join(", ");
                  }}
                >
                  {availablePermissions.map((permission) => (
                    <MenuItem key={permission.id} value={permission.id}>
                      <Checkbox checked={permissions.includes(permission.id)} />
                      <ListItemText primary={permission.name} />
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            )}
          </Grid>
        </Grid>
      </DialogContent>
      <DialogActions>
        <Button onClick={handleClose} color="primary">
          Cancel
        </Button>
        <Button onClick={handleSubmit} color="primary">
          Update Role
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default EditRoleModal;