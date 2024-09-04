import React, { useEffect } from "react";

import { Outlet } from "react-router-dom";
import Menu from "../components/Menu";


const Layout = () => {
 
  return (
    <div className="d-flex flex-column">
      <Menu />
      <Outlet />
    </div>
  );
};

export { Layout };
