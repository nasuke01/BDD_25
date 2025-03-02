import './bootstrap';
import React from "react";
import { createRoot } from "react-dom/client";
import Classement from "./components/Classement";

const root = document.getElementById("classement-root");
if (root) {
    createRoot(root).render(<Classement />);
}
