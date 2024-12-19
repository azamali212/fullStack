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
import { createUser } from "@/lib/slice/adminSlice";
import { AppDispatch, RootState } from "@/lib/store";
import { SelectChangeEvent } from "@mui/material/Select";
import { fetchRole } from "@/lib/slice/userRoleSlice";
import { fetchPermissions } from "@/lib/slice/userPermissionSlice";
import { Spinner } from "@nextui-org/react"; // Importing NextUI Spinner
import { getHospitals } from "@/lib/slice/hospital/hospitalSlice";

interface AddUserModalProps {
  open: boolean;
  handleClose: () => void;
  onUserAdded: () => void;
}

const AddUserModal: React.FC<AddUserModalProps> = ({
  open,
  handleClose,
  onUserAdded,
}) => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [role, setRole] = useState<string>(""); // Changed to store the name of the role
  const [permissions, setPermissions] = useState<string[]>([]); // Keep the IDs in state
  const [loading, setLoading] = useState(false); // Track loading state
  const [showSpinner, setShowSpinner] = useState(false); // State for spinner visibility
  const [hospital, setHospital] = useState<string>("");

  const dispatch = useDispatch<AppDispatch>();

  //Fetch Role
  const { roles = [], loading: rolesLoading } = useSelector(
    (state: RootState) => state.userRoles || {}
  );

  //Fetch Permissions
  const {
    permissions: availablePermissions = [],
    loading: permissionsLoading,
  } = useSelector((state: RootState) => state.userPermission || {});

  //Fetch hospital
  const { hospitals = [], loading: hospitalsLoading } = useSelector(
    (state: RootState) => state.hospitals || {}
  );

  console.log(hospitals);
  // Fetch roles and permissions when modal is opened
  useEffect(() => {
    if (open) {
      dispatch(fetchRole());
      dispatch(fetchPermissions());
      dispatch(getHospitals());
    }
  }, [open, dispatch]);

  // Handle form submission
  const handleSubmit = () => {
    console.log("Form data being sent:", {
      name,
      email,
      password,
      role,
      permissions,
      hospital, // Make sure hospital is passed here
    });
  
    if (
      !name.trim() ||
      !email.trim() ||
      !password.trim() ||
      !role ||
      permissions.length === 0 ||
      !hospital // Check if hospital is selected
    ) {
      console.error("Invalid form data: Missing required fields.");
      return;
    }
  
    setLoading(true);
    setShowSpinner(true);
  
    setTimeout(() => {
      dispatch(
        createUser({
          name,
          email,
          password,
          role,
          permissions: permissions.map((permissionId) => {
            const permission = availablePermissions.find(
              (perm) => perm.id === permissionId
            );
            if (!permission) {
              console.error("Permission not found:", permissionId);
              return "";
            }
            return permission.name;
          }),
          hospital_id: hospital, // Make sure to pass the hospital here
        })
      )
        .unwrap()
        .then((newUser) => {
          onUserAdded(newUser); // Trigger the parent to update the user list
          handleClose();
        })
        .catch((err) => {
          console.error("Failed to add user:", err);
        })
        .finally(() => {
          setLoading(false);
          setShowSpinner(false);
        });
    }, 3000);
  };

  const handlePermissionChange = (
    event: SelectChangeEvent<typeof permissions>
  ) => {
    const {
      target: { value },
    } = event;
    setPermissions(typeof value === "string" ? value.split(",") : value);
  };

  // Check if roles are still loading
  if (rolesLoading || permissionsLoading) {
    return <div>Loading...</div>;
  }

  // If no roles are fetched, show a message
  if (roles.length === 0) {
    return (
      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>No Roles Available</DialogTitle>
        <DialogContent>
          <div>No roles have been assigned. Please try again later.</div>
        </DialogContent>
        <DialogActions>
          <Button onClick={handleClose} color="primary">
            Close
          </Button>
        </DialogActions>
      </Dialog>
    );
  }

  return (
    <Dialog open={open} onClose={handleClose}>
      <DialogTitle>Add User</DialogTitle>
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
            <TextField
              fullWidth
              label="Password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              variant="outlined"
              required
              type="password"
            />
          </Grid>
          <Grid item xs={12}>
            <FormControl fullWidth variant="outlined" required>
              <InputLabel>Role</InputLabel>
              <Select
                value={role} // Now the value is the role name
                onChange={(e: SelectChangeEvent<string>) =>
                  setRole(e.target.value)
                } // Set the selected role's name
                label="Role"
              >
                {roles.map((role) => (
                  <MenuItem key={role.id} value={role.name}>
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
          <Grid item xs={12}>
            <FormControl fullWidth variant="outlined" required>
              <InputLabel>Hospital</InputLabel>
              <Select
                value={hospital}
                onChange={(e) => setHospital(e.target.value)} // Update hospital state here
                label="Hospital"
                disabled={hospitalsLoading} // Disable dropdown while loading
              >
                {hospitalsLoading ? (
                  <MenuItem disabled>Loading hospitals...</MenuItem>
                ) : hospitals.length === 0 ? (
                  <MenuItem disabled>No hospitals available</MenuItem>
                ) : (
                  hospitals.map((hospital) => (
                    <MenuItem key={hospital.id} value={hospital.id}>
                      {" "}
                      {/* Make sure hospital.id is set */}
                      {hospital.name}
                    </MenuItem>
                  ))
                )}
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
          Add User
        </Button>
      </DialogActions>

      {/* Loading Overlay */}
      {showSpinner && (
        <div
          className="fixed inset-0  flex justify-center items-center z-50"
          style={{ height: "100vh", width: "100vw" }} // Ensure full-screen coverage
        >
          <Spinner size="sm" color="success" label="Loading..." />{" "}
          {/* Using NextUI Spinner */}
        </div>
      )}
    </Dialog>
  );
};

export default AddUserModal;

//add Hospital in user and Role All Deyanmic
