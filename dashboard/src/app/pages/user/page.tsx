'use client'
import Dashboard from '@/app/components/layout'
import React, { useEffect } from 'react'
import { AppDispatch } from '@/lib/store';
import { useDispatch  } from "react-redux";
import UserData from './virtualData/data';
import { getUsers } from '@/lib/slice/adminSlice';

function Admin() {
    
  const dispatch = useDispatch<AppDispatch>();

    useEffect(() => {
      // Fetch users when the component mounts
      dispatch(getUsers());
    }, [dispatch]);
  return (
    <Dashboard userRole="System Administrator" userImage="" userName="" className="">
        <UserData />
    </Dashboard>
  )
}

export default Admin