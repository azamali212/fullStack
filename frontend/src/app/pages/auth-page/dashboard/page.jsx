"use client";

import { useSelector } from "react-redux";
import SystemAdminDashboard from "../../../../components/Dashboard/SystemAdminDashboard/page";
import HospitalAdminDashboard from "../../../../components/Dashboard/HospitalDashboard/page";
import NurseDashboard from "../../../../components/Dashboard/NursesDashboard/page";
import GuardDashboard from "../../../../components/Dashboard/GuardDashboard/page";
import CleanerDashboard from "../../../../components/Dashboard/CleanerDashboard/page";

export default function Dashboard() {
  const { role } = useSelector((state) => state.user);

  const renderDashboard = () => {
    switch (role) {
      case 'System Administrator':
        return <SystemAdminDashboard />;
      case 'Hospital Administrator':
        return <HospitalAdminDashboard />;
      case 'Nurses':
        return <NurseDashboard />;
      case 'Guard':
        return <GuardDashboard />;
      case 'Cleaner':
        return <CleanerDashboard />;
      default:
        return <p>No permissions available for this role.</p>;
    }
  };

  return (
    <div className="flex flex-col items-center justify-center min-h-screen bg-gray-100 text-black">
      {renderDashboard()}
    </div>
  );
}