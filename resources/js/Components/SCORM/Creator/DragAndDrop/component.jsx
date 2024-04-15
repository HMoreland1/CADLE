import { useDrag } from "react-dnd";

const useCustomDrag = ({ componentObj, columnIndex }) => {
    const [{ isDragging }, drag] = useDrag({
        type: 'component',
        item: { type: 'component', component: componentObj.component, columnIndex },
        collect: (monitor) => ({
            isDragging: monitor.isDragging(),
        }),
    });

    return { isDragging, drag };
};

export default useCustomDrag;
