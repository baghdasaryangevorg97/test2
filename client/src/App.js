import './App.css';
import React from 'react';
import Dashboard from './pages/Dashboard';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './pages/Login';
import PrivateRoute from './middleware/PrivateRoute';
import { Layout } from './pages/Layout';
import Registration from './pages/Registration';

function App() {
  return (
    <Routes>
      <Route path="/" element={<Layout />}>
        <Route
          index
          element={
            <PrivateRoute >
              <Dashboard />
            </PrivateRoute>
          }>
        </Route>
      </Route>

      <Route path="login" element={<Login />}></Route>
      <Route path="registration" element={<Registration />}></Route>
    </Routes>
  );
}

export default App;
