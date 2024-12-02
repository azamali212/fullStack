'use client'
import Dashboard from '@/app/components/layout'
import React,{useEffect} from 'react'

function DoctorDashboard() {
  useEffect(() => {
    console.log('Component mounted');
  }, []);
  return (
    <Dashboard userRole='Doctor'>
    <div>DoctorDashboard</div>
    </Dashboard>
  )
}

export default DoctorDashboard