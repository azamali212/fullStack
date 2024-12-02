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
import { addRole } from "@/lib/slice/userRoleSlice";
import { AppDispatch, RootState } from "@/lib/store";
import { SelectChangeEvent } from "@mui/material/Select";

interface AddRoleModalProps {
  open: boolean;
  handleClose: () => void;
  onRoleAdded: () => void;
}

const AddRoleModal: React.FC<AddRoleModalProps> = ({
  open,
  handleClose,
  onRoleAdded,
}) => {
  const [roleName, setRoleName] = useState("");
  const [permissions, setPermissions] = useState<number[]>([]);

  const dispatch = useDispatch<AppDispatch>();
  const {
    permissions: availablePermissions,
    loading,
    error,
  } = useSelector((state: RootState) => state.userPermission);

  useEffect(() => {
    if (open) {
      dispatch(fetchPermissions());
    }
  }, [open, dispatch]);

  const handleSubmit = () => {
    if (roleName.trim() && permissions.length > 0) {
      dispatch(addRole({ name: roleName, permission: permissions }));
      onRoleAdded();
      handleClose();
    }
  };

  return (
    <Dialog open={open} onClose={handleClose}>
      <DialogTitle>Add Role</DialogTitle>
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
                  onChange={(e: SelectChangeEvent<typeof permissions>) =>
                    setPermissions(e.target.value as number[])
                  }
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
                      <Checkbox
                        checked={permissions.indexOf(permission.id) > -1}
                      />
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
          Add Role
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default AddRoleModal;