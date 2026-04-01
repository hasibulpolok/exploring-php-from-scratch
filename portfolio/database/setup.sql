-- ============================================================
--  database/setup.sql
--  Run this once to create the portfolio database & tables.
--  Usage: mysql -u root -p < database/setup.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio_db;

-- ─── Profile ────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS profile (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(120) NOT NULL,
    nickname    VARCHAR(60),
    role        VARCHAR(160) NOT NULL,
    location    VARCHAR(120),
    email       VARCHAR(180),
    phone       VARCHAR(30),
    whatsapp    VARCHAR(30),
    address     TEXT,
    about       TEXT,
    open_to_work TINYINT(1) DEFAULT 1,
    avatar_url  VARCHAR(255),
    cover_url   VARCHAR(255),
    resume_url  VARCHAR(255),
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ─── Skills ──────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS skills (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(80) NOT NULL,
    level       TINYINT UNSIGNED NOT NULL DEFAULT 80,  -- 0-100
    category    VARCHAR(60) DEFAULT 'General',
    sort_order  INT DEFAULT 0
) ENGINE=InnoDB;

-- ─── Experience ──────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS experience (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(160) NOT NULL,
    company     VARCHAR(120),
    period      VARCHAR(80),
    description TEXT,
    sort_order  INT DEFAULT 0
) ENGINE=InnoDB;

-- ─── Projects ────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS projects (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(160) NOT NULL,
    description TEXT,
    tech_stack  VARCHAR(255),
    url         VARCHAR(255),
    image_url   VARCHAR(255),
    sort_order  INT DEFAULT 0
) ENGINE=InnoDB;

-- ─── Social Links ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS social_links (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    platform    VARCHAR(60) NOT NULL,
    url         VARCHAR(255) NOT NULL,
    icon_class  VARCHAR(80),
    sort_order  INT DEFAULT 0
) ENGINE=InnoDB;

-- ─── Contact Messages ────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS contact_messages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    sender_name VARCHAR(120) NOT NULL,
    sender_email VARCHAR(180) NOT NULL,
    subject     VARCHAR(255),
    message     TEXT NOT NULL,
    is_read     TINYINT(1) DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
--  Seed Data
-- ============================================================
INSERT INTO profile (name, nickname, role, location, email, phone, whatsapp, address, about, open_to_work)
VALUES (
    'Md Hasibul Bashar Polok',
    'Don',
    'Full-Stack Web Developer (ReactJS Specialist)',
    'Kaliganj, Dhaka, Bangladesh',
    'hasibulpolok.bdn@gmail.com',
    '+880 1XXX-XXXXXX',
    '8801XXXXXXXXX',
    'Kaliganj, Dhaka, Bangladesh',
    'I am a professional full-stack web developer specializing in ReactJS. I build modern, scalable, and user-friendly web applications. I am also involved in a zero-waste business brand called Eosphare Living.',
    1
);

INSERT INTO skills (name, level, category, sort_order) VALUES
('HTML & CSS',   92, 'Frontend', 1),
('JavaScript',   88, 'Frontend', 2),
('ReactJS',      90, 'Frontend', 3),
('PHP',          80, 'Backend',  4),
('MySQL',        78, 'Backend',  5),
('Git & GitHub', 85, 'DevOps',   6),
('API Integration', 82, 'Backend', 7);

INSERT INTO experience (title, company, period, description, sort_order) VALUES
('Front-End Developer — ReactJS Specialist', 'Freelance & Personal Projects', '2022 – Present',
 'Building responsive, high-performance React applications with modern hooks, state management, and REST API integration. Delivering pixel-perfect UIs from Figma/XD designs.', 1),
('Full-Stack Web Developer', 'Freelance', '2021 – Present',
 'End-to-end development covering PHP/MySQL backends, RESTful APIs, and React frontends. Managing full project lifecycles from requirement gathering to deployment.', 2);

INSERT INTO projects (title, description, tech_stack, url, sort_order) VALUES
('DevPolok YouTube Channel', 'A tech-education YouTube channel sharing tutorials on web development, ReactJS, and modern JavaScript for the Bangladeshi developer community.',
 'Video Production, Screen Recording, Tutorials', 'https://youtube.com/@DevPolok', 1),
('Eosphare Living', 'Official website for a zero-waste lifestyle brand — featuring product showcases, blog, and e-commerce integration.',
 'ReactJS, PHP, MySQL, CSS3', '#', 2),
('Freelance Web Applications', 'Collection of client projects including business dashboards, e-commerce storefronts, and admin panels built with React and PHP.',
 'ReactJS, PHP, MySQL, REST API', '#', 3);

INSERT INTO social_links (platform, url, icon_class, sort_order) VALUES
('YouTube',  'https://youtube.com/@DevPolok', 'fab fa-youtube',  1),
('GitHub',   '#',                             'fab fa-github',   2),
('LinkedIn', '#',                             'fab fa-linkedin', 3),
('Fiverr',   '#',                             'fab fa-fiverr',   4);
