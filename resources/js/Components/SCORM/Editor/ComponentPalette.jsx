// ComponentPalette.jsx
import { DraggableText, DraggableTextTitle, DraggableEmail, DraggableSpacer} from './DraggableComponents';

const ComponentPalette = () => {
    return (
        <div style={{display: 'grid', gridTemplateColumns: 'repeat(auto-fit, 45%)', gap: '5%'}}>

                <DraggableSpacer/>
                <DraggableEmail/>
                <DraggableText text="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed accumsan ultrices justo, ut vehicula turpis laoreet nec. Quisque nec est ac sapien sodales commodo. In hac habitasse platea dictumst. Morbi volutpat leo sit amet magna vestibulum, quis convallis justo vulputate. Pellentesque nec risus vitae purus cursus scelerisque. Nullam eu augue eget libero dapibus consequat. Integer varius est in enim ultrices convallis. Curabitur vitae consequat dolor. Vivamus sodales metus sed tellus tempus, eget tempus leo congue. Donec id libero nec ipsum fermentum malesuada. Vivamus vitae fermentum purus. Maecenas lacinia odio et mi rutrum, nec blandit nisi varius. Vivamus feugiat ex non velit condimentum, eget laoreet urna laoreet. Sed sodales aliquam nibh, et dictum urna volutpat eu."/>
                <DraggableTextTitle title="Title" alignment="left" text="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed accumsan ultrices justo, ut vehicula turpis laoreet nec. Quisque nec est ac sapien sodales commodo. In hac habitasse platea dictumst. Morbi volutpat leo sit amet magna vestibulum, quis convallis justo vulputate. Pellentesque nec risus vitae purus cursus scelerisque. Nullam eu augue eget libero dapibus consequat. Integer varius est in enim ultrices convallis. Curabitur vitae consequat dolor. Vivamus sodales metus sed tellus tempus, eget tempus leo congue. Donec id libero nec ipsum fermentum malesuada. Vivamus vitae fermentum purus. Maecenas lacinia odio et mi rutrum, nec blandit nisi varius. Vivamus feugiat ex non velit condimentum, eget laoreet urna laoreet. Sed sodales aliquam nibh, et dictum urna volutpat eu."/>
        </div>

    );
};

export default ComponentPalette;
