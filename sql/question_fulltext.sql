
ALTER TABLE `question` ADD FULLTEXT KEY `search` (`title`,`body`);
