import React, { useState, useEffect } from "react";
import {
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  Button,
  TextField,
  Grid,
  FormControl,
  InputLabel,
  Select,
  MenuItem,
  Checkbox,
  ListItemText,
} from "@mui/material";
import { useDispatch, useSelector } from "react-redux";
import { updateUser } from "@/lib/slice/adminSlice";
import { AppDispatch, RootState } from "@/lib/store";
import { SelectChangeEvent } from "@mui/material/Select";
import { fetchRole } from "@/lib/slice/userRoleSlice";
import { fetchPermissions } from "@/lib/slice/userPermissionSlice";

interface EditUserModalProps {
  open: boolean;
  handleClose: () => void;
  user: {
    id: number;
    name: string;
    email: string;
    role: string;
    permissions: string[];
    password?: string; // Optional, to show or not based on requirements
  } | null;
  onUserUpdated: () => void;
}

const EditUserModal: React.FC<EditUserModalProps> = ({
  open,
  handleClose,
  user,
  onUserUpdated,
}) => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [role, setRole] = useState("");
  const [permissions, setPermissions] = useState<string[]>([]);

  const dispatch = useDispatch<AppDispatch>();


  const { roles = [], loading: rolesLoading } = useSelector(
    (state: RootState) => state.userRoles || {}
  );
  const {
    permissions: availablePermissions = [],
    loading: permissionsLoading,
  } = useSelector((state: RootState) => state.userPermission || {});

  useEffect(() => {
    if (open && user) {
      setName(user.name || "");
      setEmail(user.email || "");
      setRole(user.role || "");
      setPermissions(user.permissions || []);
      dispatch(fetchRole());
      dispatch(fetchPermissions());
    }
  }, [open, user, dispatch]);

  const handleSubmit = () => {
    if (user) {
      const updatedUser = {
        name,
        email,
        role,
        permissions: permissions.map((permissionId) => {
          const permission = availablePermissions.find(
            (perm) => perm.id === permissionId
          );
          return permission ? permission.name : "";
        }),
      };

      dispatch(
        updateUser({
          user: String(user.id), // ID should be a string in API call
          userData: updatedUser,
        })
      )
        .unwrap()
        .then(() => {
          onUserUpdated(); // Notify parent to refresh data
          handleClose(); // Close the modal
        })
        .catch((err) => {
          console.error("Failed to update user:", err);
        });
    }
  };

  const handlePermissionChange = (
    event: SelectChangeEvent<typeof permissions>
  ) => {
    const {
      target: { value },
    } = event;
    setPermissions(typeof value === "string" ? value.split(",") : value);
  };

  if (rolesLoading || permissionsLoading) {
    return <div>Loading...</div>;
  }

  return (
    <Dialog open={open} onClose={handleClose}>
      <DialogTitle>Edit User</DialogTitle>
      <DialogContent>
        <Grid container spacing={2}>
          <Grid item xs={12}>
            <TextField
              fullWidth
              label="Name"
              value={name}
              onChange={(e) => setName(e.target.value)}
              variant="outlined"
              required
            />
          </Grid>
          <Grid item xs={12}>
            <TextField
              fullWidth
              label="Email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              variant="outlined"
              required
              type="email"
            />
          </Grid>
          <Grid item xs={12}>
            <FormControl fullWidth variant="outlined" required>
              <InputLabel>Role</InputLabel>
              <Select
                value={role}
                onChange={(e: SelectChangeEvent<string>) => {
                  const selectedRole = roles.find(
                    (role) => role.id === e.target.value
                  );
                  setRole(selectedRole ? selectedRole.name : "");
                }}
                label="Role"
              >
                {roles.map((role) => (
                  <MenuItem key={role.id} value={role.id}>
                    {role.name}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
          </Grid>
          <Grid item xs={12}>
            <FormControl fullWidth variant="outlined">
              <InputLabel>Permissions</InputLabel>
              <Select
                multiple
                value={permissions}
                onChange={handlePermissionChange}
                renderValue={(selected) => {
                  return selected
                    .map((id) => {
                      const permission = availablePermissions.find(
                        (perm) => perm.id === id
                      );
                      return permission ? permission.name : "";
                    })
                    .join(", ");
                }}
              >
                {availablePermissions.map((permission) => (
                  <MenuItem key={permission.id} value={permission.id}>
                    <Checkbox
                      checked={permissions.indexOf(permission.id) > -1}
                    />
                    <ListItemText primary={permission.name} />
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
          </Grid>
        </Grid>
      </DialogContent>
      <DialogActions>
        <Button onClick={handleClose} color="primary">
          Cancel
        </Button>
        <Button onClick={handleSubmit} color="primary">
          Update User
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default EditUserModal;