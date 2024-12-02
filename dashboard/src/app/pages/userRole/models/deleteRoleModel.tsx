import React from 'react';
import { Modal, Box, Typography, Button } from '@mui/material';

interface DeleteRoleModalProps {
  open: boolean;
  handleClose: () => void;
  handleDelete: () => void;
  roleName: string;
}

const DeleteRoleModal: React.FC<DeleteRoleModalProps> = ({
  open,
  handleClose,
  handleDelete,
  roleName,
}) => {
  return (
    <Modal open={open} onClose={handleClose}>
      <Box
        sx={{
          position: 'absolute',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          width: 400,
          backgroundColor: 'white',
          padding: 3,
          boxShadow: 24,
          borderRadius: 2,
        }}
      >
        <Typography variant="h6" gutterBottom>
          Are you sure you want to delete the role "{roleName}"?
        </Typography>
        <Box sx={{ display: 'flex', justifyContent: 'space-between' }}>
          <Button onClick={handleClose} variant="outlined" color="secondary">
            Cancel
          </Button>
          <Button
            onClick={() => {
              handleDelete();
              handleClose();
            }}
            variant="contained"
            color="error"
          >
            Delete
          </Button>
        </Box>
      </Box>
    </Modal>
  );
};

export default DeleteRoleModal;