import React, { useState } from "react";
import { FixedSizeList as List } from "react-window";
import { useSelector, useDispatch } from "react-redux";
import { RootState } from "@/lib/store";
import { deleteUser } from "@/lib/slice/adminSlice";
import Link from "next/link";
import { Bar } from "react-chartjs-2";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend,
} from "chart.js";

// Register Chart.js components
ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend
);

interface Admin {
  id: number;
  name: string;
  email: string;
  role: string;
  hospital?: {
    name: string;
  };
}

function UserData() {
  const [searchTerm, setSearchTerm] = useState("");
  const dispatch = useDispatch();

  // Get users from Redux store
  const users = useSelector((state: RootState) => state.admins.users);

  // Filter users
  const filteredUsers = users.filter((user) => {
    return (
      (user.name &&
        user.name.toLowerCase().includes(searchTerm.toLowerCase())) ||
      (user.email &&
        user.email.toLowerCase().includes(searchTerm.toLowerCase())) ||
      (user.role && user.role.toLowerCase().includes(searchTerm.toLowerCase()))
    );
  });

  // Chart data
  const totalUsers = users.length;
  const usersWithHospital = users.filter((user) => user.hospital).length;

  const chartData = {
    labels: ["Total Users", "Users with Hospital"],
    datasets: [
      {
        label: "User Count",
        data: [totalUsers, usersWithHospital],
        backgroundColor: ["#4CAF50", "#FF9800"],
        borderRadius: 8,
        barThickness: 20,
        borderSkipped: false,
      },
    ],
  };

  const rowHeight = 50;
  const itemCount = filteredUsers.length;
  const listHeight = rowHeight * itemCount > 500 ? 500 : rowHeight * itemCount;

  const Row = ({
    index,
    style,
  }: {
    index: number;
    style: React.CSSProperties;
  }) => {
    const user = filteredUsers[index];
    if (!user) return null;

    const handleDelete = () => {
      dispatch(deleteUser(user.id.toString()));
    };

    return (
      <div
        style={style}
        className="flex justify-between items-center p-4 mb-2 border border-gray-200 rounded-lg bg-white shadow-md hover:shadow-xl hover:bg-gray-100 transition-all duration-300"
      >
        <div className="w-1/6 text-center font-medium">{user.id}</div>
        <div className="w-1/4 font-medium">{user.name}</div>
        {/* Adjusted email column */}
        <div className="w-1/4 whitespace-normal break-words text-sm">
          {user.email}
        </div>
        <div className="w-1/6 text-center">{user.role}</div>
        <div className="w-1/6">
          {user.hospital ? user.hospital.name : "No Hospital"}
        </div>
        <div className="flex space-x-2">
          <button className="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md focus:outline-none">
            Edit
          </button>
          <button
            className="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-md focus:outline-none"
            onClick={handleDelete}
          >
            Delete
          </button>
        </div>
      </div>
    );
  };

  return (
    <div className="p-6 bg-gray-50 min-h-screen">
      {/* Header */}
      <div className="mb-6">
        <input
          type="text"
          placeholder="Search Users..."
          className="w-full p-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
        />
      </div>

      {/* Content Section */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* User List */}
        <div className="lg:col-span-2 bg-white shadow rounded-lg p-4">
          <h2 className="text-xl font-semibold mb-4">User List</h2>
          <Link href="#">
            <List
              height={listHeight}
              itemCount={itemCount}
              itemSize={rowHeight}
              width="100%"
            >
              {Row}
            </List>
          </Link>
        </div>

        {/* Chart */}
        <div className="bg-white shadow rounded-lg p-4">
          <h2 className="text-xl font-semibold mb-4">Statistics</h2>
          <div className="relative w-full h-80 animate-fadeIn">
            <Bar
              data={chartData}
              options={{
                responsive: true,
                plugins: {
                  title: {
                    display: true,
                    text: "User and Hospital Statistics",
                    font: {
                      size: 16,
                    },
                  },
                  tooltip: {
                    mode: "index",
                    intersect: false,
                  },
                },
              }}
            />
          </div>
        </div>
      </div>
    </div>
  );
}

export default UserData;
