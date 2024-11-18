'use client'
import Dashboard from '@/app/components/layout'
import React,{useEffect} from 'react'


function HospitalDashboard() {
  useEffect(() => {
    console.log('Component mounted');
  }, []);
  return (
    <Dashboard userRole='Hospital Administrator'>
    <div>HospitalDashboard</div>
    </Dashboard>
  )
}

export default HospitalDashboard