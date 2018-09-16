import PointIndex from "./components/points/PointIndex";
import PointCreate from "./components/points/PointCreate";
import CategoryList from "./components/categories/CategoryList";

export default [
    {
        path: "/",
        name: "home",
        component: PointIndex,
    },
    {
        path: "/categories",
        name: "categoryList",
        component: CategoryList,
    },
    {
        path: "/points-create",
        name: "pointCreate",
        component: PointCreate,
    },
];