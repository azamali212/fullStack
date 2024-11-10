import React from 'react'
import Navbar from '../ui/navbar/navbar'
import Sidebar from '../ui/sidebar/sidebar';

function Dashboard({children}) {
  return (
    <div>
    <div>
        <Navbar />
    </div>

    <div>
        <Sidebar />
        {children}
    </div>
    </div>
  )
}

export default Dashboard