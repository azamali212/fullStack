"use client";

import * as React from "react";
import Dashboard from "@/app/components/layout";
import { Paper, Divider } from "@mui/material";
import Chart from 'chart.js/auto';
import { DataGrid, GridColDef } from "@mui/x-data-grid";
import LocalHospitalOutlinedIcon from "@mui/icons-material/LocalHospitalOutlined";
import MedicationLiquidOutlinedIcon from "@mui/icons-material/MedicationLiquidOutlined";
import PersonOutlineOutlinedIcon from "@mui/icons-material/PersonOutlineOutlined";
import SupervisorAccountOutlinedIcon from "@mui/icons-material/SupervisorAccountOutlined";
import LockOpenOutlinedIcon from "@mui/icons-material/LockOpenOutlined";

const columns: GridColDef[] = [
  { field: "id", headerName: "ID", width: 70 },
  { field: "firstName", headerName: "First name", width: 130 },
  { field: "lastName", headerName: "Last name", width: 130 },
  {
    field: "age",
    headerName: "Age",
    type: "number",
    width: 90,
  },
  {
    field: "fullName",
    headerName: "Full name",
    description: "This column has a value getter and is not sortable.",
    sortable: false,
    width: 160,
    valueGetter: (value, row) => `${row.firstName || ""} ${row.lastName || ""}`,
  },
];

const rows = [
  { id: 1, lastName: "Snow", firstName: "Jon", age: 35 },
  { id: 2, lastName: "Lannister", firstName: "Cersei", age: 42 },
  { id: 3, lastName: "Lannister", firstName: "Jaime", age: 45 },
  { id: 4, lastName: "Stark", firstName: "Arya", age: 16 },
  { id: 5, lastName: "Targaryen", firstName: "Daenerys", age: null },
  { id: 6, lastName: "Melisandre", firstName: null, age: 150 },
  { id: 7, lastName: "Clifford", firstName: "Ferrara", age: 44 },
  { id: 8, lastName: "Frances", firstName: "Rossini", age: 36 },
  { id: 9, lastName: "Roxie", firstName: "Harvey", age: 65 },
];

const paginationModel = { page: 0, pageSize: 5 };

export default function Super() {
  const [counter, setCounter] = React.useState(0);
  const totalCount = 100;
  // Static Doughnut chart data
  const doughnutData = [65, 15, 20];

  React.useEffect(() => {
    // Bar chart initialization logic
    const ctx1 = document.getElementById(
      "bar-chart-1"
    ) as HTMLCanvasElement | null;
    const ctx2 = document.getElementById(
      "bar-chart-2"
    ) as HTMLCanvasElement | null;
    const ctx3 = document.getElementById(
      "bar-chart-3"
    ) as HTMLCanvasElement | null;
    const ctxDoughnut = document.getElementById(
      "doughnut-chart"
    ) as HTMLCanvasElement | null;

    const initializeChart = (
      ctx: HTMLCanvasElement | null,
      chartId: string,
      type: string
    ) => {
      if (ctx) {
        const config = {
          type: type, // Bar or Doughnut type based on passed parameter
          data:
            type === "bar"
              ? {
                  labels: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                  ],
                  datasets: [
                    {
                      label: new Date().getFullYear(),
                      backgroundColor: "#3182ce", // Blue bars
                      borderColor: "#3182ce", // Border color
                      data: [65, 78, 66, 44, 56, 67, 75],
                      fill: false,
                    },
                    {
                      label: new Date().getFullYear() - 1,
                      backgroundColor: "#f6ad55", // Orange bars
                      borderColor: "#f6ad55", // Border color
                      data: [40, 68, 86, 74, 56, 60, 87],
                      fill: false,
                    },
                  ],
                }
              : {
                  labels: ["Red", "Blue", "Yellow"],
                  datasets: [
                    {
                      data: doughnutData, // Static Doughnut chart data
                      backgroundColor: ["#3182ce", "#f6ad55", "#fbbf24"],
                    },
                  ],
                },
          options: {
            maintainAspectRatio: false,
            responsive: true,
            title: {
              display: false,
              text: "Sales Charts",
              fontColor: "white",
            },
            legend: {
              labels: {
                fontColor: "white",
              },
              align: "end",
              position: "bottom",
            },
            tooltips: {
              mode: "index",
              intersect: false,
            },
            hover: {
              mode: "nearest",
              intersect: true,
            },
            scales:
              type === "bar"
                ? {
                    x: {
                      ticks: {
                        fontColor: "rgba(255,255,255,.7)",
                      },
                      grid: {
                        display: false,
                        borderDash: [2],
                        borderDashOffset: [2],
                        color: "rgba(33, 37, 41, 0.3)",
                      },
                    },
                    y: {
                      ticks: {
                        fontColor: "rgba(255,255,255,.7)",
                      },
                      grid: {
                        borderDash: [3],
                        borderDashOffset: [3],
                        drawBorder: false,
                        color: "rgba(255, 255, 255, 0.15)",
                      },
                    },
                  }
                : {},
          },
        };

        new Chart(ctx, config);
      }
    };

    // Initialize Bar charts
    initializeChart(ctx1, "bar-chart-1", "bar");
    initializeChart(ctx2, "bar-chart-2", "bar");
    initializeChart(ctx3, "bar-chart-3", "bar");

    // Initialize Doughnut chart (static data)
    if (ctxDoughnut) {
      initializeChart(ctxDoughnut, "doughnut-chart", "doughnut");
    }

    // Counter logic
    const interval = setInterval(() => {
      setCounter((prevCount) => {
        if (prevCount >= totalCount) {
          clearInterval(interval); // Stop the counter when the total is reached
          return totalCount;
        }
        return prevCount + 1; // Increment the counter
      });
    }, 10); // Update every 100ms

    return () => clearInterval(interval);
  }, []); // Empty dependency array ensures the effect runs only once when the component is mounted

  return (
    <Dashboard className="pt-6" userRole="System Administrator" userName="" userImage="">
      <div className="flex flex-row justify-between items-center p-4">
        <div>
          <Paper
            elevation={0}
            className="bg-gradient-to-r from-blue-400/80 to-blue-600/70 border border-gray-200 rounded-lg shadow-lg w-60 h-28"
          >
            <h5 className="text-xl p-2 font-semibold text-white">Hospitals</h5>
            <div className="flex flex-row justify-around items-center p-2">
              <div>
                <LocalHospitalOutlinedIcon
                  style={{
                    fontSize: "3rem",
                    color: "rgb(64, 145, 221)", // #3182ce
                    backgroundColor: "rgba(255, 255, 255, 0.8)", // White with transparency
                    borderRadius: "50%",
                    padding: "10px",
                    boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)", // Slight shadow for depth
                  }}
                />
              </div>
              <div className="text-4xl font-extrabold text-white">
                {counter}
              </div>
            </div>
          </Paper>
        </div>
        <div>
          <Paper
            elevation={0}
            className="bg-gradient-to-r from-green-400/80 to-green-600/70 border border-gray-200 rounded-lg shadow-lg w-60 h-28"
          >
            <h5 className="text-xl p-2 font-semibold text-white">Doctor</h5>
            <div className="flex flex-row justify-around items-center p-2">
              <div>
                <MedicationLiquidOutlinedIcon
                  style={{
                    fontSize: "3rem",
                    color: "rgb(34, 197, 94)", // #22c55e (Green)
                    backgroundColor: "rgba(255, 255, 255, 0.8)", // White with transparency
                    borderRadius: "50%",
                    padding: "10px",
                    boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)", // Slight shadow for depth
                  }}
                />
              </div>
              <div className="text-4xl font-extrabold text-white">
                {counter}
              </div>
            </div>
          </Paper>
        </div>
        <div>
          <Paper
            elevation={0}
            className="bg-gradient-to-r from-purple-400/80 to-purple-600/70 border border-gray-200 rounded-lg shadow-lg w-60 h-28"
          >
            <h5 className="text-xl p-2 font-semibold text-white">Users</h5>
            <div className="flex flex-row justify-around items-center p-2">
              <div>
                <PersonOutlineOutlinedIcon
                  style={{
                    fontSize: "3rem",
                    color: "rgb(139, 92, 246)", // #8b5cf6 (Purple)
                    backgroundColor: "rgba(255, 255, 255, 0.8)", // White with transparency
                    borderRadius: "50%",
                    padding: "10px",
                    boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)", // Slight shadow for depth
                  }}
                />
              </div>
              <div className="text-4xl font-extrabold text-white">
                {counter}
              </div>
            </div>
          </Paper>
        </div>
        <div>
          <Paper
            elevation={0}
            className="bg-gradient-to-r from-orange-400/80 to-orange-600/70 border border-gray-200 rounded-lg shadow-lg w-60 h-28"
          >
            <h5 className="text-xl p-2 font-semibold text-white">Roles</h5>
            <div className="flex flex-row justify-around items-center p-2">
              <div>
                <SupervisorAccountOutlinedIcon
                  style={{
                    fontSize: "3rem",
                    color: "rgb(249, 115, 22)", // #f97316 (Orange)
                    backgroundColor: "rgba(255, 255, 255, 0.8)", // White with transparency
                    borderRadius: "50%",
                    padding: "10px",
                    boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)", // Slight shadow for depth
                  }}
                />
              </div>
              <div className="text-4xl font-extrabold text-white">
                {counter}
              </div>
            </div>
          </Paper>
        </div>
        <Paper
          elevation={0}
          className="bg-gradient-to-r from-red-400/80 to-red-600/70 border border-gray-200 rounded-lg shadow-lg w-60 h-28"
        >
          <h5 className="text-xl p-2 font-semibold text-white">Permissions</h5>
          <div className="flex flex-row justify-around items-center p-2">
            <div>
              <LockOpenOutlinedIcon
                style={{
                  fontSize: "3rem",
                  color: "rgb(239, 68, 68)", // #ef4444 (Red)
                  backgroundColor: "rgba(255, 255, 255, 0.8)", // White with transparency
                  borderRadius: "50%",
                  padding: "10px",
                  boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)", // Slight shadow for depth
                }}
              />
            </div>
            <div className="text-4xl font-extrabold text-white">{counter}</div>
          </div>
        </Paper>
      </div>

      <div className="flex flex-row w-full pt-2md:w-full justify-between space-x-4">
        {/* Paper card with Bar Chart taking up 20% */}
        <Paper
          elevation={0}
          className="bg-white border border-gray-300 rounded-lg shadow-lg w-1/2 h-full flex flex-col justify-between"
        >
          <div className="p-2 flex-grow">
            {/* Bar Chart Canvas */}
            <canvas id="bar-chart-2" className="w-full h-full"></canvas>
          </div>
        </Paper>
        {/* Paper card with Doughnut chart taking up 50% */}
        <Paper
          elevation={0}
          className="bg-white border border-gray-300 rounded-lg shadow-lg w-1/2 h-full flex flex-col justify-between"
        >
          <div className="flex flex-row justify-center items-center p-2 flex-grow">
            {/* Doughnut chart */}
            <canvas id="doughnut-chart" className="max-w-96 h-96"></canvas>
          </div>
        </Paper>
      </div>

      <div className="flex flex-row w-full pt-6 md:w-full justify-between space-x-4">
        <Paper sx={{ height: 400, width: "100%" }}>
          <DataGrid
            rows={rows}
            columns={columns}
            initialState={{ pagination: { paginationModel } }}
            pageSizeOptions={[5, 10]}
            checkboxSelection
            sx={{ border: 0 }}
          />
        </Paper>
      </div>
    </Dashboard>
  );
}
