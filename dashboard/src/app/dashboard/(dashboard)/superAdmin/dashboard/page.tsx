'use client'
import Dashboard from '@/app/components/layout'
import React,{useEffect} from 'react'


function Super() {
  useEffect(() => {
    console.log('Component mounted');
  }, []);
  return (
    <Dashboard userRole='System Administrator'>
    <div>Super</div>
    </Dashboard>
  )
}

export default Super