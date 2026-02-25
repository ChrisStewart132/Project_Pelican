CREATE TABLE system_prompts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL
);

CREATE TABLE architect_prompts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL
);

CREATE TABLE project_prompts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL
);

CREATE TABLE code_interfaces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    dependencies VARCHAR(255) DEFAULT '' -- Comma-separated IDs of required interfaces
);

-- Seed Data
INSERT INTO system_prompts (title, content) VALUES 
('Default AI System', 'You are an elite expert software engineer. You write clean, modular, and scalable code. You follow all instructions precisely.');

INSERT INTO architect_prompts (title, content) VALUES 
('Game Architect', 'You will act as the lead game architect. Focus on decoupling systems, using single-responsibility principles, and ensuring code is highly performant.');

INSERT INTO project_prompts (title, content) VALUES 
('Asteroids Clone Web App', 'Build a classic Asteroids game clone using HTML5 Canvas and vanilla JavaScript. Include player ship, wrapping screen bounds, asteroids breaking into smaller pieces, and a score system.');

INSERT INTO code_interfaces (id, title, content, dependencies) VALUES 
(1, 'Grid Based World', 'INTERFACE GridWorld:\n- init(width, height)\n- addObject(obj, x, y)\n- removeObject(id)\n- getObjectsAt(x, y)\nDefines a spatial grid for entity management.', ''),
(2, 'Rigid Body Physics', 'INTERFACE PhysicsBody:\n- update(deltaTime)\n- applyForce(fx, fy)\nProperties: position, velocity, acceleration, mass.', ''),
(3, 'Grid Based Building System', 'INTERFACE GridBuilder:\n- placeStructure(structureId, gridX, gridY)\n- validatePlacement(gridX, gridY)\nIntegrates with GridWorld to handle player construction.', '1'),
(4, 'Asteroid Entity Module', 'INTERFACE AsteroidEntity:\n- split()\n- onCollision(other)\nRequires PhysicsBody for movement.', '2');