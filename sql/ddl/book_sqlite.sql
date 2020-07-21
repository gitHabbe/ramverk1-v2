--
-- Creating a sample table.
--



--
-- Table Book
--
DROP TABLE IF EXISTS Book;
CREATE TABLE Book (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "author" TEXT NOT NULL,
    "title" TEXT NOT NULL,
    "image" TEXT NOT NULL
);
